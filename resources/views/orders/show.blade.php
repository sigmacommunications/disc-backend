@extends('layout.trending_menu')
@section('title', 'Order Details - Order #' . $order->id)

@section('content')
    <div class="container py-5">
        <div class="mb-4">
            <a href="{{ route('orders.index') }}" class="text-decoration-none">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Orders
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Details Card -->
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header header-sound text-white py-3 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold">Order #{{ $order->id }}</h3>
                        @if ($order->status == 'pending')
                            <a href="{{ route('payment.page', $order->id) }}" class="btn btn-light">
                                <i class="fa-solid fa-credit-card me-1"></i> Complete Payment
                            </a>
                        @endif
                    </div>

                    <div class="card-body p-0">
                        <!-- Order Status -->
                        <div class="p-3 bg-light border-bottom">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="text-muted">Order Date:</span>
                                    <span class="ms-2 fw-bold">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <div>
                                    <span class="text-muted">Status:</span>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-warning text-dark ms-2">Pending Payment</span>
                                    @elseif($order->status == 'paid')
                                        <span class="badge bg-success ms-2">Paid</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-info ms-2">Shipped</span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge header-sound ms-2">Delivered</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger ms-2">Cancelled</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-3">
                            <h4 class="mb-3">Order Items</h4>

                            @foreach ($order->orderItems as $item)
                                <div class="d-flex mb-3 border-bottom pb-3">
                                    <div class="flex-shrink-0">
                                        @if ($item->merchItem && $item->merchItem->image_path)
                                            <img src="{{ asset($item->merchItem->image_path) }}" alt="{{ $item->name }}"
                                                class="rounded" style="width: 70px; height: 70px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 70px; height: 70px;">
                                                <i class="fa-solid fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1">{{ $item->name }}</h5>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="text-muted">Quantity: {{ $item->quantity }}</span>
                                                @if (!empty($item->options))
                                                    <div class="small text-muted mt-1">
                                                        @foreach (json_decode($item->options, true) as $key => $value)
                                                            <span>{{ ucfirst($key) }}: {{ $value }}</span>
                                                            @if (!$loop->last)
                                                                |
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="fw-bold">${{ number_format($item->price, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Order Total -->
                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <span class="fw-bold fs-5">Total:</span>
                                <span class="fw-bold fs-5">${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Shipping Information -->
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header bg-light py-3">
                        <h4 class="mb-0 fw-bold">Shipping Information</h4>
                    </div>
                    <div class="card-body">
                        <p class="fw-bold mb-1">{{ $order->shipping_name }}</p>
                        <p class="mb-1">{{ $order->shipping_address1 }}</p>
                        @if ($order->shipping_address2)
                            <p class="mb-1">{{ $order->shipping_address2 }}</p>
                        @endif
                        <p class="mb-1">{{ $order->shipping_city }}, {{ $order->shipping_state }}
                            {{ $order->shipping_zip }}</p>
                        <div class="mt-3 pt-3 border-top">
                            <span class="text-muted">Shipping Method:</span>
                            <p class="fw-bold mb-0">{{ $order->shipping_method }}</p>
                        </div>
                    </div>
                </div>

                <!-- Billing Information -->
                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-header bg-light py-3">
                        <h4 class="mb-0 fw-bold">Billing Information</h4>
                    </div>
                    <div class="card-body">
                        <p class="fw-bold mb-1">{{ $order->billing_name }}</p>
                        <p class="mb-1">{{ $order->billing_address1 }}</p>
                        @if ($order->billing_address2)
                            <p class="mb-1">{{ $order->billing_address2 }}</p>
                        @endif
                        <p class="mb-1">{{ $order->billing_city }}, {{ $order->billing_state }}
                            {{ $order->billing_zip }}</p>
                        <p class="mb-1">Phone: {{ $order->billing_phone }}</p>
                        <p class="mb-0">Email: {{ $order->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .badge {
            font-size: 0.85em;
            padding: 0.5em 0.75em;
        }
    </style>
@endpush
