<div class="cart-amount">
    <div class="amount">
        <h5>Subtotals:</h5>
        <p>${{ number_format($subtotal, 2) }}</p>
    </div>
    <div class="amount">
        <h5>Sales Tax:</h5>
        <p>${{ number_format($salesTax, 2) }}</p>
    </div>
    <div class="amount">
        <h5>Grand Total:</h5>
        <h4>${{ number_format($grandTotal, 2) }}</h4>
    </div>
    <a href="{{ route('checkout.index') }}" class="checkout">Check Out</a>
</div>
