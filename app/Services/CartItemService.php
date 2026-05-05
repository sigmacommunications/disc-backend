<?php
namespace App\Services;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Log;

class CartItemService
{
    public static function fetchPrintifyProducts()
    {
        $shopId = config('services.printify.shop_id');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.printify.api_token'),
        ])->get("https://api.printify.com/v1/shops/{$shopId}/products.json");

        return $response->json()['data'] ?? [];
    }
    public static function calculateCartItemPrice($item)
    {
        if (!$item->printify_data) {
            // Regular merch – take the Eloquent relation price
            $item->unit_price = $item->merchItem->price;
            $item->display_name = $item->merchItem->name;
            $item->display_image = asset('storage/' . optional($item->merchItem->images->first())->image_path);
        } else {
            // Printify – look up the variant price once
            $productId = data_get($item->printify_data, 'line_items.0.product_id');
            $variantId = data_get($item->printify_data, 'line_items.0.variant_id');
            $data = CartItemService::variantPrice($productId, $variantId);
            $priceCents = $data['price'];
            $product = $data['product'];

            $item->unit_price = $priceCents / 100; // cents → dollars
            // dd($product);
            $item->display_name = $product['title'] ?? "Printify Product";
            $item->display_image = $product['images'][0]['src'] ?? asset('images/default.png'); // Default image if not available
        }
        return $item;
    }

    // Fetches price for a specific variant (in cents)
    public static function variantPrice(string $productId, int $variantId): array
    {
        $shopId = config('services.printify.shop_id');
        $product = Http::withToken(config('services.printify.api_token'))
            ->get("https://api.printify.com/v1/shops/{$shopId}/products/{$productId}.json")
            ->json();

        $variant = collect($product['variants'] ?? [])
            ->firstWhere('id', $variantId);

        $priceCents = (int) ($variant['price'] ?? 0);
        return ['price' => $priceCents, 'product' => $product];
    }
    public static function getOrderData(string $printifyOrderId): array
    {
        $shopId = config('services.printify.shop_id');

        try {
            $response = Http::withToken(config('services.printify.api_token'))
                ->get("https://api.printify.com/v1/shops/{$shopId}/orders/{$printifyOrderId}.json")
                ->throw();

            return $response->json();

        } catch (RequestException $e) {
            // Log the low-level HTTP error
            Log::error('Printify API request failed', [
                'printify_order_id' => $printifyOrderId,
                'message' => $e->getMessage(),
            ]);
            throw new Exception('Unable to reach Printify. Please try again later.');
        } catch (Exception $e) {
            // Catch any other unexpected exception
            Log::error('Unexpected error fetching Printify order data', [
                'printify_order_id' => $printifyOrderId,
                'message' => $e->getMessage(),
            ]);
            throw new Exception('An unexpected error occurred. Please contact support.');
        }
    }
}
