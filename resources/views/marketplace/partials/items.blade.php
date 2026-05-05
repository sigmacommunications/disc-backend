<div class="row">
    @foreach ($merchItems as $item)
        <div class="col-lg-3 col-md-4 my-2">
            <div class="image-box">
                <a @if (!empty($item->printify_product_id)) href="{{ route('marketplace.show', $item->printify_product_id) }}"
                 @else href="{{ route('marketplace.show', $item->id) }}" @endif
                    class="imganchor">
                    @php

                        $firstImage = $item->images->first();
                        if (!$firstImage) {
                            $src = asset('images/default.png');
                        } else {
                            $path = $firstImage->image_path;
                            $src = Str::startsWith($path, ['http://', 'https://']) ? $path : asset("storage/$path");
                        }
                    @endphp

                    <img src="{{ $src }}" alt="product" class="p1">
                </a>
                <div class="star">
                    <i class="fa {{ in_array($item->id, $wishlist) ? 'fa-star' : 'fa-star-o' }}"></i>
                </div>
                <a
                    href="{{ route('marketplace.show', !empty($item->printify_product_id) ? $item->printify_product_id : $item->id) }}">
                    <h3 class="lorem">{{ Str::limit($item->name, 30, '…') }}</h3>
                </a>

                <div class="price">
                    <h3 class="price1">${{ $item->price }}</h3>
                </div>

                @auth
                    <div class="addtocart">
                        @if (!empty($item->printify_product_id))
                            {{-- If this is a Printify product, link to the show page instead of cart --}}
                            <a href="{{ route('marketplace.show', $item->printify_product_id) }}" class="cart1">
                                <i class="fa fa-cart-shopping"></i>
                                View Product
                            </a>
                        @else
                            {{-- Otherwise, allow adding to cart via POST, including a hidden merch_id --}}
                            <form action="{{ route('marketplace.cart.add') }}" method="POST"
                                class="{{ in_array($item->id, $cartItems) ? 'btn-cart-added' : '' }}">
                                @csrf
                                <input type="hidden" name="merch_item_id" value="{{ $item->id }}">
                                <button type="submit" class="cart1">
                                    <i class="fa fa-cart-shopping"></i>
                                    {{ in_array($item->id, $cartItems) ? 'Added' : 'Add To Cart' }}
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('marketplace.wishlist.add', $item) }}" method="POST"
                            class="{{ in_array($item->id, $wishlist) ? 'btn-wishlist-added' : '' }}">
                            @csrf
                            <button type="submit" class="cart1">
                                <i class="fa fa-heart"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="w-full">
                        <a href="{{ route('login') }}" style="gap:5px" class="btn w-full btn-primary">
                            <i class="fa fa-heart heart"></i> Add to Wishlist
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    @endforeach
</div>
<style>
    .image-box {
        border: 1px solid rgba(255, 255, 255, 0.1);
        background-color: rgba(30, 30, 30, 0.5);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .image-box:hover {
        transform: translateY(-5px);
    }

    .item-image-container {
        overflow: hidden;
        height: 200px;
    }

    .p1 {
        transition: transform 0.5s ease;
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .image-box:hover .p1 {
        transform: scale(1.05);
    }

    .item-details {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .addtocart {
        margin-top: auto;
    }

    .btn-outline-danger:hover {
        background-color: #FF6347;
    }

    .star i {
        filter: drop-shadow(0px 0px 2px rgba(0, 0, 0, 0.5));
        transition: transform 0.3s ease;
    }

    .star i:hover {
        transform: scale(1.2);
    }

    /* Ensure dark theme compatibility */
    .lorem {
        color: white;
    }

    .btn {
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .cart1 {
        font-weight: 500;
    }
</style>
