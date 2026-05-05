@extends('layout.app')
@section('title', "Order Details - Order #{$order->id}")
@section('content')
    <div class="container mt-4">
        <a href="{{ route('admin_orders.index') }}" class="btn btn-secondary mb-3">Back to Orders</a>
        <h2>Order Details - Order #{{ $order->id }}</h2>

        <!-- Order Information -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Order Information</strong>
            </div>
            <div class="card-body">
                <p><strong>User:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                <p><strong>Placed At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <!-- Billing Information -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Billing Information</strong>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->billing_name }}</p>
                <p><strong>Phone:</strong> {{ $order->billing_phone }}</p>
                <p>
                    <strong>Address:</strong>
                    {{ $order->billing_address1 }}
                    @if ($order->billing_address2)
                        , {{ $order->billing_address2 }}
                    @endif,
                    {{ $order->billing_city }}, {{ $order->billing_state }} - {{ $order->billing_zip }}
                </p>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Shipping Information</strong>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                <p>
                    <strong>Address:</strong>
                    {{ $order->shipping_address1 }}
                    @if ($order->shipping_address2)
                        , {{ $order->shipping_address2 }}
                    @endif,
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}
                </p>
                <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
                @if ($order->shipping_charges)
                    <p><strong>Shipping Charges:</strong> ${{ number_format($order->shipping_charges, 2) }}</p>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <strong>Order Items</strong>
            </div>
            <div class="card-body">
                @if ($order->orderItems->isNotEmpty())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No order items found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
