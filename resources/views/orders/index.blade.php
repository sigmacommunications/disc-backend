@extends('layout.trending_menu')
@section('title', 'Orders - My Orders')

@section('content')
    <div class="container py-5">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header header-sound text-white py-3">
                <h2 class="mb-0 fw-bold">My Orders</h2>
            </div>

            <div class="card-body p-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($orders->isEmpty())
                    <div class="text-center py-5">
                        <img src="{{ asset('assets/images/empty-orders.svg') }}" alt="No Orders" style="width: 120px;">
                        <h3 class="mt-3">No orders yet</h3>
                        <p class="text-muted">When you place orders, they will appear here</p>
                        <a href="{{ route('marketplace.index') }}" class="btn btn-primary mt-2">
                            <i class="fa-solid fa-shopping-bag me-2"></i>Browse Marketplace
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="ps-3 fw-bold">#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>{{ $order->orderItems->count() }}</td>
                                        <td>${{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            @if ($order->payment_status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending Payment</span>
                                            @elseif($order->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($order->payment_status == 'shipped')
                                                <span class="badge bg-info">Shipped</span>
                                            @elseif($order->payment_status == 'delivered')
                                                <span class="badge header-sound">Delivered</span>
                                            @elseif($order->payment_status == 'cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye me-1"></i> View
                                            </a>

                                            @if ($order->payment_status == 'pending')
                                                <a href="{{ route('payment.page', $order->id) }}"
                                                    class="btn btn-sm btn-primary ms-1">
                                                    <i class="fa-solid fa-credit-card me-1"></i> Pay Now
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-3 py-3">
                        {{ $orders->links() }}
                    </div>
                @endif
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

        .table>:not(caption)>*>* {
            padding: 1rem 0.5rem;
            vertical-align: middle;
        }
    </style>
@endpush
