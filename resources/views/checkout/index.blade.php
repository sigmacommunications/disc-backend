{{-- resources/views/marketplace/checkout.blade.php --}}
@extends('layout.trending_menu')

@section('title', 'Marketplace - Checkout')

@section('content')
    <section class="checkout-mainsec">
        <div class="container">
            <div class="row">
                {{-- Left: Form --}}
                <div class="col-md-6">
                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        {{-- Ensure we always send a flag --}}
                        <input type="hidden" name="same_as_billing" id="same_as_billing_input" value="0">

                        {{-- 1. Email --}}
                        <div class="address mb-4">
                            <h3> Email Address</h3>
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 2. Billing Address --}}
                        <div class="address mb-4">
                            <h3> Billing Address</h3>

                            @foreach (['name' => ['Full Name', 'text'], 'phone' => ['Phone Number', 'tel'], 'address1' => ['Street Address Line 1', 'text'], 'address2' => ['Street Address Line 2 (opt.)', 'text'], 'city' => ['City', 'text'], 'state' => ['State/Province', 'text'], 'zip' => ['ZIP/Postal', 'text']] as $field => [$label, $type])
                                <div class="form-group mb-2">
                                    <label for="billing_{{ $field }}">{{ $label }}</label>
                                    <input type="{{ $type }}" id="billing_{{ $field }}"
                                        name="billing_{{ $field }}" value="{{ old("billing_{$field}") }}"
                                        class="form-control @error("billing_{$field}") is-invalid @enderror"
                                        @unless ($field === 'address2') required @endunless>
                                    @error("billing_{$field}")
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        {{-- 3. Same as billing --}}
                        <div class="form-group form-check mb-4">
                            <input type="checkbox" id="same_as_billing" name="same_as_billing" value="1"
                                class="form-check-input" {{ old('same_as_billing') ? 'checked' : '' }}>
                            <label class="form-check-label" for="same_as_billing">
                                Shipping address is the same as billing address
                            </label>
                        </div>

                        {{-- 4. Shipping Address --}}
                        <div class="address mb-4" id="shipping_address_section">
                            <h3> Shipping Address</h3>

                            @foreach ([
            'name' => ['Full Name', 'text'],
            'address1' => ['Street Address Line 1', 'text'],
            'address2' => ['Street Address Line 2 (opt.)', 'text'],
            'city' => ['City', 'text'],
            'state' => ['State/Province', 'text'],
            'zip' => ['ZIP/Postal', 'text'],
        ] as $field => [$label, $type])
                                <div class="form-group mb-2">
                                    <label for="shipping_{{ $field }}">{{ $label }}</label>
                                    <input type="{{ $type }}" id="shipping_{{ $field }}"
                                        name="shipping_{{ $field }}" value="{{ old("shipping_{$field}") }}"
                                        class="form-control @error("shipping_{$field}") is-invalid @enderror"
                                        @unless ($field === 'address2') required @endunless>
                                    @error("shipping_{$field}")
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        {{-- 5. Shipping Method --}}
                        <div class="ship mb-4">
                            <h3>Shipping Method</h3>
                            <div class="form-check">
                                <input type="radio" name="shipping_method" id="free_shipping" value="free"
                                    class="form-check-input @error('shipping_method') is-invalid @enderror"
                                    {{ old('shipping_method') === 'free' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="free_shipping">
                                    Free Shipping (2–4 Business Days)
                                </label>
                            </div>
                            @error('shipping_method')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 6. Submit --}}
                        <button type="submit" class="btn checkout">Continue to Payment</button>
                    </form>
                </div>

                {{-- Right: Order Summary --}}
                <div class="col-md-6">
                    @foreach ($cartItems as $cartItem)
                        <div class="prdct d-flex align-items-center mb-3" data-item-id="{{ $cartItem->id }}">
                            <img src="{{ $cartItem->display_image }}" class="me-3"
                                style="width:60px;height:60px;object-fit:cover;" alt="{{ $cartItem->display_name }}">

                            <div class="flex-grow-1">
                                <h5>{{ \Illuminate\Support\Str::limit($cartItem->display_name, 20) }}</h5>
                                <p class="mb-0"><small>Qty: {{ $cartItem->quantity }}</small></p>
                            </div>

                            <div>
                                <strong>
                                    ${{ number_format($cartItem->unit_price * $cartItem->quantity, 2) }}
                                </strong>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const checkbox = document.getElementById('same_as_billing');
        const hiddenFlag = document.getElementById('same_as_billing_input');
        const shippingBlock = document.getElementById('shipping_address_section');

        function syncShipping() {
            const on = checkbox.checked;
            hiddenFlag.value = on ? '1' : '0';
            if (on) {
                ['name', 'address1', 'address2', 'city', 'state', 'zip'].forEach(f => {
                    document.getElementById(`shipping_${f}`).value =
                        document.getElementById(`billing_${f}`).value;
                });
                shippingBlock.style.display = 'none';
            } else {
                shippingBlock.style.display = 'block';
            }
        }

        checkbox.addEventListener('change', syncShipping);
        document.addEventListener('DOMContentLoaded', syncShipping);
    </script>
@endsection
