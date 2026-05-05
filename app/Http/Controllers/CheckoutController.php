<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartItemService;
use Auth;
use DB;
use Http;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CheckoutController extends CartController
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()
            ->with('merchItem.images')  // eager-load local images
            ->get()
            ->map(fn($item) => CartItemService::calculateCartItemPrice($item));

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cartItems'));
    }
    public function payment($id)
    {
        $order = Order::findOrFail($id);
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // If the order is already paid, redirect to the order detail page
        if ($order->payment_status !== 'pending') {
            return redirect()->route('orders.show', $order->id)
                ->with('info', 'This order has already been processed.');
        }

        if (!empty($order->printify_order_id)) {
            try {
                $cartData = CartItemService::getOrderData($order->printify_order_id);
                $shippingCost = data_get($cartData, 'total_shipping', 0);
                $shippingCost /= 100;

                $order->setAttribute('shipping_charges', $shippingCost);
                // dd($order);
                $order->total_price += $shippingCost;

                // $order->setRelation('orderItems', collect(data_get($cartData, 'line_items', [])));
            } catch (\Exception $e) {
                return redirect()
                    ->route('orders.show', $order->id)
                    ->with('error', $e->getMessage());
            }
        }

        $order->load('orderItems');

        return view('payment.page', compact('order'));
    }

    public function store(Request $request)
    {
        // 1. If they ticked “same as billing”, copy billing → shipping
        if ($request->boolean('same_as_billing')) {
            $request->merge([
                'shipping_name' => $request->billing_name,
                'shipping_address1' => $request->billing_address1,
                'shipping_address2' => $request->billing_address2,
                'shipping_city' => $request->billing_city,
                'shipping_state' => $request->billing_state,
                'shipping_zip' => $request->billing_zip,
            ]);
        }

        // 2. Now validate everything in one shot
        $validated = $request->validate([
            'email' => 'required|email',
            'billing_name' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address1' => 'required|string|max:255',
            'billing_address2' => 'nullable|string|max:255',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_zip' => 'required|string|max:20',

            'shipping_name' => 'required|string|max:255',
            'shipping_address1' => 'required|string|max:255',
            'shipping_address2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zip' => 'required|string|max:20',

            'shipping_method' => 'required|string|in:free', // adjust as needed
        ]);

        // 3. Load cart & compute totals
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('merchItem')->get()
            ->map(fn($item) => CartItemService::calculateCartItemPrice($item));

        if ($cartItems->isEmpty()) {
            return back()->withError('Your cart is empty.');
        }
        // dd($cartItems);
        $totalPrice = $cartItems->sum(fn($item) => $item->unit_price * $item->quantity);

        // 4. Persist order + items in a transaction
        $order = null;
        DB::transaction(function () use ($user, $validated, $cartItems, $totalPrice, &$order) {
            $order = Order::create([
                'user_id' => $user->id,
                'email' => $validated['email'],
                'billing_name' => $validated['billing_name'],
                'billing_phone' => $validated['billing_phone'],
                'billing_address1' => $validated['billing_address1'],
                'billing_address2' => $validated['billing_address2'],
                'billing_city' => $validated['billing_city'],
                'billing_state' => $validated['billing_state'],
                'billing_zip' => $validated['billing_zip'],

                'shipping_name' => $validated['shipping_name'],
                'shipping_address1' => $validated['shipping_address1'],
                'shipping_address2' => $validated['shipping_address2'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_zip' => $validated['shipping_zip'],

                'shipping_method' => $validated['shipping_method'],
                'total_price' => $totalPrice,
                'payment_status' => 'pending',
            ]);

            // 5. Create order items and Printify order if necessary
            $printifyItems = [];

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'merch_item_id' => $item->merch_item_id,
                    'quantity' => $item->quantity,
                    'price' => $item->unit_price,
                    'name' => $item->merchItem->name,
                    'printify_data' => $item->printify_data ?? null,
                ]);

                // If item is a Printify product, store it for Printify order creation
                if ($item->printify_data) {
                    $printifyItems[] = $item;
                }
            }

            // 6. If there are Printify items, place the order on Printify
            if (!empty($printifyItems)) {
                $printifyResponse = $this->placePrintifyOrder($printifyItems, $validated);
                // Update order with printify order id from response
                $order->update(['printify_order_id' => $printifyResponse['id']]);
            }
            // 7. Clear cart
            $user->cartItems()->delete();
        });

        // 8. Redirect to your payment flow
        return redirect()
            ->route('payment.page', $order->id)
            ->withSuccess('Order placed successfully.');
    }
    protected function placePrintifyOrder(array $items, array $validated)
    {
        $shopId = config('services.printify.shop_id');
        $orderData = [
            'external_id' => 'order-' . uniqid(),
            'line_items' => [],
            'shipping_method' => 1,
            'send_shipping_notification' => true,
            'address_to' => [
                'first_name' => $validated['shipping_name'],
                'last_name' => '',
                'email' => $validated['email'],
                'phone' => $validated['billing_phone'],
                'country' => 'US',
                'region' => $validated['shipping_state'],
                'address1' => $validated['shipping_address1'],
                'address2' => $validated['shipping_address2'] ?? '',
                'city' => $validated['shipping_city'],
                'zip' => $validated['shipping_zip'],
            ],
        ];

        foreach ($items as $item) {
            $productId = data_get($item->printify_data, 'line_items.0.product_id');
            $printProviderId = data_get($item->printify_data, 'line_items.0.print_provider_id');
            $blueprintId = data_get($item->printify_data, 'line_items.0.blueprint_id');
            $variantId = data_get($item->printify_data, 'line_items.0.variant_id');

            $orderData['line_items'][] = [
                'product_id' => $productId,
                'print_provider_id' => $printProviderId,
                'blueprint_id' => $blueprintId,
                'variant_id' => $variantId,
                // 'print_areas' => $printAreas,
                'quantity' => $item->quantity,
            ];
        }

        // $jsonData = json_encode($orderData, JSON_PRETTY_PRINT);
        // dd($jsonData);

        $response = Http::withToken(config('services.printify.api_token'))
            ->post("https://api.printify.com/v1/shops/{$shopId}/orders.json", $orderData);

        if ($response->failed()) {
            $errorMessage = 'Failed to place your Printify order due to an external service error. Please contact support.';
            \Log::error("Printify order placement error: " . $response->body());
            // The thrown exception will include a stacktrace that can be viewed in your logs.
            throw new \Exception($errorMessage . "\nError Details: " . $response->body());
        }

        return $response->json();
    }


    public function paymentSuccess(Request $request)
    {
        // Initialize PayPal client and get access token
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Fetch transaction details using the provided token
        $response = $provider->capturePaymentOrder($request->token);

        // Check if the payment was successful
        if ($response['status'] === 'COMPLETED') {

            // Retrieve the order from the database
            $order = Order::findOrFail((int) $request->order_id);

            // Validate the payment by comparing the payment amount and ensuring the order belongs to the authenticated user
            if ($this->isValidPayment($order, $response)) {

                // Update the order status and save the PayPal order ID
                $order->update([
                    'payment_status' => 'paid',
                    'paypal_order_id' => $response['id'],
                ]);

                // Redirect to orders page with a success message
                return redirect()->route('orders.index')->with('success', 'Payment successful!');
            } else {
                // Redirect to orders page with an error message if payment verification fails
                return redirect()->route('orders.index')->with('error', 'Payment verification failed!');
            }

        }

        // If payment status is not 'COMPLETED', redirect to cancellation page with an error
        return redirect()->route('paypal.cancel')->with('error', 'Payment failed or was canceled.');
    }

    /**
     * Validate the payment by comparing the order total price with the payment amount
     * and ensuring the order belongs to the authenticated user.
     *
     * @param \App\Models\Order $order
     * @param array $response
     * @return bool
     */
    private function isValidPayment(Order $order, array $response)
    {
        // dd($response['purchase_units'][0]['payments']['captures'][0]['amount']['value']);
        $paymentAmount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];

        // Check if the payment amount matches the order total and the order belongs to the authenticated user
        return $order->total_price == $paymentAmount && $order->user_id == Auth::user()->id;
    }


    public function paymentCancel()
    {
        return redirect()->route('orders.index')
            ->with('error', 'Payment was canceled.');
    }

    public function charge(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $order = Order::findOrFail($request->order_id);
        //     // Convert the order total to cents (Stripe uses cents)
        $amount = (int) ($order->total_price * 100);

        $orderData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amount,
                    ],
                    'description' => 'Payment for Order #' . $request->input('order_id'),
                ],
            ],
            'application_context' => [
                'return_url' => route('paypal.success', ['order_id' => $order->id]),
                'cancel_url' => route('paypal.cancel'),
            ],
        ];

        $response = $provider->createOrder($orderData);

        if (isset($response['id'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('paypal.cancel');
    }

    // public function charge(Request $request)
    // {
    //     // Validate the request to ensure the stripeToken and order_id are provided.
    //     $request->validate([
    //         'stripeToken' => 'required|string',
    //         'order_id' => 'required|integer|exists:orders,id',
    //     ]);

    //     // Retrieve the order using the provided order_id.
    //     $order = Order::findOrFail($request->order_id);
    //     // Convert the order total to cents (Stripe uses cents)
    //     $amount = (int) ($order->total_price * 100);

    //     // Set your Stripe secret key from config/services.php.
    //     Stripe::setApiKey(env('STRIPE_SECRET'));

    //     try {
    //         // Create a new charge using the Stripe API.
    //         $charge = Charge::create([
    //             'amount' => $amount,
    //             'currency' => 'usd', // adjust currency if needed
    //             'description' => 'Payment for Order #' . $order->id,
    //             'source' => $request->stripeToken,
    //         ]);

    //         // Optionally update your order status and save the Stripe charge ID.
    //         $order->update([
    //             'payment_status' => 'paid',
    //             'stripe_charge_id' => $charge->id,
    //         ]);

    //         // Redirect to an order confirmation page or similar.
    //         return redirect()->route('marketplace.index', $order->id)
    //             ->with('success', 'Payment successful!');

    //     } catch (\Exception $e) {
    //         // In case of an error, you may log the error and return with an error message.
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }
    public function orderIndex()
    {
        $orders = auth()->user()->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }


    public function orderShow(Order $order)
    {
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.merchItem');

        return view('orders.show', compact('order'));
    }
}
