@extends('layout.trending_menu')
@section('title', 'Marketplace - Wishlist')
@section('content')
    <section class="wish-mainsec">
        <section class="wish-sec1">
            <div class="container">
                <div class="prdct-carthead">
                    <div class="item">
                        <h5>PRODUCTS NAME</h5>
                    </div>
                    <div class="price">
                        <h5>UNIT PRICE</h5>
                    </div>
                    <div class="quantity">
                        <h5>STOCKS STATUS</h5>
                    </div>
                    <div class="totals">
                        <h5>ACTIONS</h5>
                    </div>
                </div>

                @forelse ($wishlistItems as $wishlistItem)
                    @php
                        $item = $wishlistItem->merchItem;
                        $inCart = in_array($item->id, $cartItems ?? []);
                        $inWishlist = in_array($item->id, $wishlist ?? []);
                    @endphp

                    <div class="prdct-cart align-items-center">
                        <div class="item">
                            <img src="{{ asset('storage/' . $item->images->first()->image_path) }}" class="w-25"
                                alt="{{ $item->name }}">
                            <h4>{{ $item->name }}</h4>
                        </div>
                        <div class="price">
                            <h4>${{ number_format($item->price, 2) }}</h4>
                        </div>
                        <div class="quantity">
                            <h4>{{ $item->stock + 1 > 0 ? 'In Stock' : 'Out of Stock' }}</h4>
                        </div>
                        <div class="totals d-flex">
                            {{-- ADD TO CART BUTTON --}}
                            <form action="{{ route('marketplace.cart.add', $item) }}" method="POST" class="me-2">
                                @csrf
                                @if ($item->printify_product_id)
                                    <input type="hidden" name="printify_product_id"
                                        value="{{ $item->printify_product_id }}">
                                @else
                                    <input type="hidden" name="merch_item_id" value="{{ $item->id }}">
                                @endif
                                <button type="submit"
                                    class="btn btn-primary btn-lg d-flex align-items-center gap-2 {{ $inCart ? 'btn-cart-added' : '' }}">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>{{ $inCart ? 'Added to Cart' : 'Add to Cart' }}</span>
                                </button>
                            </form>


                        </div>
                    </div>

                @empty
                    <p>No products found.</p>
                @endforelse

                <div class="text-center mt-4">
                    <a href="#" class="checkout btn  btn-lg">
                        Check Out
                    </a>
                </div>
            </div>
        </section>
    </section>
@endsection
