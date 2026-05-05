<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MerchItem;
use App\Services\CartItemService;
use Auth;
use Http;
use Illuminate\Http\Request;
use Str;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('merchItem.images')
            ->get()
            ->map(fn($item) => CartItemService::calculateCartItemPrice($item));

        $subtotal = $cartItems->sum(fn($i) => $i->unit_price * $i->quantity);
        $salesTax = $subtotal * config('cart.tax_rate', 0.00);
        $coupon = session('coupon');
        $couponDiscount = $coupon ? $coupon->discount_amount : 0;
        $grandTotal = $subtotal + $salesTax - $couponDiscount;

        return view('cart.index', compact(
            'cartItems',
            'subtotal',
            'salesTax',
            'grandTotal'
        ));
    }

    /* ──────────────────────────────────────────────────────────────
     |  PATCH /cart/{cartItem} – AJAX/normal quantity update
     ───────────────────────────────────────────────────────────── */
    public function update(Request $request, Cart $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cartItem->update(['quantity' => $request->input('quantity')]);

        /* ---------- If this came from AJAX, return the new totals ----- */
        if ($request->wantsJson()) {
            $user = auth()->user();
            $cartItems = $user->cartItems->map(fn($item) => CartItemService::calculateCartItemPrice($item));
            $subtotal = $cartItems->sum(fn($item) => $item->unit_price * $item->quantity);
            $salesTax = $subtotal * config('cart.tax_rate', 0.00);
            $grandTotal = $subtotal + $salesTax;


            $html = view('partials.cart_summary', compact(
                'subtotal',
                'salesTax',
                'grandTotal'
            ))->render();

            return response()->json(['updatedTotalsHtml' => $html]);
        }

        /* ---------- Full-page fallback ------------------------------- */
        return back()->with('success', 'Cart updated successfully.');
    }

    /* ──────────────────────────────────────────────────────────────
     |  Helper – returns variant price in CENTS (integer)
     ───────────────────────────────────────────────────────────── */
    private function variantPrice(string $productId, int $variantId): int
    {
        $shopId = config('services.printify.shop_id');

        $product = Http::withToken(config('services.printify.api_token'))
            ->get("https://api.printify.com/v1/shops/{$shopId}/products/{$productId}.json")
            ->json();

        $variant = collect($product['variants'] ?? [])
            ->firstWhere('id', $variantId);

        return (int) ($variant['price'] ?? 0);   // already in cents
    }
    private function getUserItems(string $itemType)
    {
        return Auth::check() ? Auth::user()->$itemType()->pluck('merch_item_id')->toArray() : [];
    }
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return $this->redirectToLoginWithMessage('You need to login to add to cart.');
        }

        // If this is a product form...
        if ($request->filled('printify_product_id')) {
            $validated = $request->validate([
                'printify_product_id' => 'required|string',
                'variant_id' => 'required|integer',
            ]);

            $product = $this->fetchPrintifyProducts()
                ->firstWhere('id', $validated['printify_product_id']);

            if (!$product) {
                abort(404, 'Printify product not found.');
            }

            // Pull out the right print_area object for this variant
            $printArea = collect($product['print_areas'])
                ->first(fn($area) => in_array(
                    $validated['variant_id'],
                    $area['variant_ids'] ?? []
                ));

            // Build exactly the structure Printify wants:
            $printifyPayload = [
                'external_id' => Str::uuid()->toString(),
                'line_items' => [
                    [
                        'product_id' => $product['id'],
                        'print_provider_id' => $product['print_provider_id'],
                        'blueprint_id' => $product['blueprint_id'],
                        'variant_id' => $validated['variant_id'],
                        'print_areas' => $printArea['placeholders'] ?? [],
                    ]
                ],
                'shipping_method' => 1,
                'send_shipping_notification' => true,
            ];
            return $this->togglePrintifyInCart($printifyPayload, $product['id']);
        }

        // Otherwise assume a normal MerchItem
        $validated = $request->validate([
            'merch_item_id' => 'required|exists:merch_items,id',
        ]);

        $merchItem = MerchItem::findOrFail($validated['merch_item_id']);
        return $this->toggleMerchItemInCart($merchItem);
    }
    private function redirectToLoginWithMessage(string $message)
    {
        return redirect()->route('login')->with('error', $message);
    }
    protected function fetchPrintifyProducts()
    {
        $shopId = config('services.printify.shop_id');
        $resp = Http::withToken(config('services.printify.api_token'))
            ->get("https://api.printify.com/v1/shops/{$shopId}/products.json")
            ->json('data', []);
        return collect($resp);
    }
    // Helper method to add or remove item from cart
    private function toggleMerchItemInCart($merchItem)
    {
        $existing = Cart::where('user_id', Auth::id())
            ->where('merch_item_id', $merchItem->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->route('marketplace.index')
                ->with('success', 'Item removed from cart.');
        }

        Cart::create([
            'user_id' => Auth::id(),
            'merch_item_id' => $merchItem->id,
            'quantity' => 1,
        ]);

        return redirect()->route('marketplace.index')
            ->with('success', 'Item added to cart.');
    }
    private function togglePrintifyInCart(array $data, $productId)
    {
        // Try to find an identical entry
        $existing = Cart::where('user_id', Auth::id())
            ->whereJsonContains('printify_data->external_id', $data['external_id'])
            ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->route('marketplace.index')
                ->with('success', 'item removed from cart.');
        }
        $merchItem = MerchItem::where('printify_product_id', $productId)->select('id', 'printify_product_id')->firstOrFail();
        Cart::create([
            'user_id' => Auth::id(),
            'merch_item_id' => $merchItem->id,
            'printify_data' => $data,
            'quantity' => 1,
        ]);

        return redirect()->route('marketplace.index')
            ->with('success', 'item added to cart.');
    }
}
