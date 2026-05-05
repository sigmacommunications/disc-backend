@extends('layout.trending_menu')
@section('title', 'Payment Page')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to Order
                    </a>
                </div>

                <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
                    <div class="card-header header-sound text-white text-center py-4">
                        <h2 class="mb-0 fw-bold">Complete Payment</h2>
                        <p class="mb-0 mt-2">Order #{{ $order->id }}</p>
                    </div>

                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-file-invoice-dollar fs-1 me-3"></i>
                                    <div>
                                        <h5 class="mb-1">Order Total</h5>
                                        <span class="fs-4 fw-bold">${{ number_format($order->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mt-3 mt-md-0">
                                    <i class="fa-solid fa-box fs-1 me-3"></i>
                                    <div>
                                        <h5 class="mb-1">Items</h5>
                                        <span class="fs-4 fw-bold">{{ $order->orderItems->count() }} items</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- PayPal Button Container -->
                        <div id="paypal-button-container" class="d-flex justify-content-center">
                            <!-- PayPal button will be rendered here -->
                        </div>
                    </div>

                    <div class="card-footer bg-light py-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="fa-solid fa-shield-alt text-success"></i>
                                <small class="d-block mt-1">Secure</small>
                            </div>
                            <div class="col-4">
                                <i class="fa-solid fa-lock text-success"></i>
                                <small class="d-block mt-1">Encrypted</small>
                            </div>
                            <div class="col-4">
                                <i class="fa-solid fa-clock text-success"></i>
                                <small class="d-block mt-1">Fast</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-header bg-light py-3">
                        <h4 class="mb-0 fw-bold">Order Summary</h4>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach ($order->orderItems as $item)
                                <li class="list-group-item px-3 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold d-block">{{ $item->name }}</span>
                                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                    </div>
                                    <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="p-3 border-top">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span>${{ number_format($order->shipping_charges, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top fw-bold">
                                <span>Total</span>
                                <span>${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}&currency=USD"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ $order->total_price }}'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Send payment details to the server
                    window.location.href =
                        "{{ route('paypal.success') }}?token=" + data.orderID +
                        "&order_id={{ $order->id }}";
                });
            },
            onCancel: function(data) {
                window.location.href = "{{ route('paypal.cancel') }}";
            }
        }).render('#paypal-button-container');
    </script>
@endsection
