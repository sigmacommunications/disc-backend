{{-- resources/views/marketplace/cart.blade.php --}}
@extends('layout.trending_menu')

@section('title', 'Marketplace - Cart')

@section('content')
    <section class="cart-mainsec">
        <section class="cart-sec1">
            <div class="container">
                <div class="prdct-carthead">
                    <div class="item">
                        <h5>ITEMS</h5>
                    </div>
                    <div class="price">
                        <h5>PRICE</h5>
                    </div>
                    <div class="quantity">
                        <h5>QUANTITY</h5>
                    </div>
                    <div class="totals">
                        <h5>TOTALS</h5>
                    </div>
                </div>

                @forelse($cartItems as $cartItem)
                    <div class="prdct-cart" data-item-id="{{ $cartItem->id }}">
                        <div class="item">
                            <img src="{{ asset('storage/' . $cartItem->merchItem->images->first()->image_path) }}"
                                class="w-25" alt="{{ $cartItem->merchItem->name }}">
                            <h4>{{ $cartItem->merchItem->name }}</h4>
                        </div>
                        {{-- Unit price --}}
                        <div class="price">
                            <h4>${{ number_format($cartItem->unit_price, 2) }}</h4>
                        </div>
                        <div class="quantity">
                            <input type="number" class="cart-qty" min="1" max="10" step="1"
                                value="{{ $cartItem->quantity }}">
                        </div>
                        <div class="totals">
                            <h4 class="line-total">
                                ${{ number_format($cartItem->unit_price * $cartItem->quantity, 2) }}
                            </h4>
                        </div>
                    </div>
                @empty
                    <p>No items in cart.</p>
                @endforelse
            </div>
        </section>

        <section class="cart-sec2">
            <div class="container" id="cart-summary-container">
                @include('partials.cart_summary', [
                    'subtotal' => $subtotal,
                    'salesTax' => $salesTax,
                    'grandTotal' => $grandTotal,
                ])
            </div>
        </section>
    </section>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('input.cart-qty').forEach(input => {
            input.addEventListener('change', function() {
                const container = this.closest('.prdct-cart');
                const itemId = container.dataset.itemId;
                const qty = this.value;

                // 1. Optimistic line‑total update
                const price = parseFloat(container.querySelector('.price h4').innerText.replace('$', ''));
                container.querySelector('.line-total').innerText = '$' + (price * qty).toFixed(2);

                // 2. Show loader on cart summary
                const cartSummaryContainer = document.querySelector('#cart-summary-container');
                const originalContent = cartSummaryContainer.innerHTML;

                // Create loader HTML (simple text version)
                const loaderHTML = `
            <div class="cart-amount">
                <div class="cart-loader">
                    <div class="amount">
                        <h5>Subtotals:</h5>
                        <p>Loading...</p>
                    </div>
                    <div class="amount">
                        <h5>Sales Tax:</h5>
                        <p>Loading...</p>
                    </div>
                    <div class="amount">
                        <h5>Grand Total:</h5>
                        <h4>Loading...</h4>
                    </div>
                </div>
                <a href="#" class="checkout">Loading...</a>
            </div>
        `;

                cartSummaryContainer.innerHTML = loaderHTML;

                // 3. AJAX PUT
                fetch(`/cart/${itemId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: qty
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Update failed');
                        return res.json();
                    })
                    .then(data => {
                        // 4. Replace loader with updated content
                        cartSummaryContainer.innerHTML = data.updatedTotalsHtml;
                    })
                    .catch(err => {
                        console.error(err);
                        // Restore original content on error
                        cartSummaryContainer.innerHTML = originalContent;
                        alert('Could not update cart. Please try again.');
                    });
            });
        });
    </script>
@endsection
