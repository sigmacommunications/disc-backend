@extends('layout.trending_menu')

@section('title', "DISC-{$merchItem->name}")

@section('content')
    <div class="product-details">
        <div class="container py-5">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('marketplace.index') }}" class="text-light">Marketplace</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $merchItem->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Product Images Section -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="product-images">
                        <!-- Main Image -->
                        <div class="main-image-container mb-3 position-relative">
                            @if ($merchItem->images->count() > 0)
                                <img id="main-product-image"
                                    src="{{ asset('storage/' . $merchItem->images->first()->image_path) }}"
                                    class="img-fluid rounded main-image" alt="{{ $merchItem->name }}">

                                @if ($merchItem->images->count() > 1)
                                    <button class="btn-image-nav btn-image-prev" onclick="navigateImage(-1)">
                                        <i class="fa fa-chevron-left"></i>
                                    </button>
                                    <button class="btn-image-nav btn-image-next" onclick="navigateImage(1)">
                                        <i class="fa fa-chevron-right"></i>
                                    </button>
                                @endif
                            @else
                                <img src="{{ asset('images/default.png') }}" class="img-fluid rounded main-image"
                                    alt="{{ $merchItem->name }}">
                            @endif
                        </div>

                        <!-- Thumbnail Gallery -->
                        @if ($merchItem->images->count() > 1)
                            <div class="thumbnail-gallery">
                                <div class="row g-2">
                                    @foreach ($merchItem->images as $image)
                                        <div class="col-3">
                                            <div class="thumbnail-item {{ $loop->first ? 'active' : '' }}"
                                                onclick="updateMainImage('{{ asset('storage/' . $image->image_path) }}')">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                    class="img-fluid rounded" alt="{{ $merchItem->name }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="col-lg-6">
                    <div class="product-info text-light">
                        <h1 class="product-title mb-2">{{ $merchItem->name }}</h1>

                        <div class="artist-info mb-3">
                            <span class="text-light-50">By</span>
                            <a href="{{ route('artists.show', $merchItem->user) }}" class="artist-link">
                                {{ $merchItem->user->name }}
                            </a>
                        </div>

                        <div class="product-price mb-4">
                            <h2 class="price">${{ number_format($merchItem->price, 2) }}</h2>
                        </div>

                        <div class="product-actions d-flex flex-wrap gap-2 mb-4">
                            @auth
                                <form action="{{ route('marketplace.cart.add') }}" method="POST" class="me-2">
                                    @csrf
                                    <input type="hidden" name="merch_item_id" value="{{ $merchItem->id }}">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg d-flex align-items-center gap-2 {{ in_array($merchItem->id, $cartItems ?? []) ? 'btn-cart-added' : '' }}">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span>{{ in_array($merchItem->id, $cartItems ?? []) ? 'Added to Cart' : 'Add to Cart' }}</span>
                                    </button>
                                </form>

                                <form action="{{ route('marketplace.wishlist.add', $merchItem) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-outline-light btn-lg {{ in_array($merchItem->id, $wishlist ?? []) ? 'btn-wishlist-added' : '' }}">
                                        <i
                                            class="fa {{ in_array($merchItem->id, $wishlist ?? []) ? 'fa-heart' : 'fa-heart' }}"></i>
                                        <span class="d-none d-md-inline ms-1">Wishlist</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                    <i class="fa fa-sign-in me-2"></i> Login to Purchase
                                </a>
                            @endauth
                        </div>

                        <div class="product-description mb-4">
                            <h3 class="section-title">Description</h3>
                            <div class="description-content">
                                {{ $merchItem->description }}
                            </div>
                        </div>

                        <div class="product-details-meta">
                            <div class="meta-item">
                                <span class="meta-label">Product ID:</span>
                                <span class="meta-value">{{ $merchItem->id }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Category:</span>
                                <span class="meta-value">{{ $merchItem->category ?? 'Merchandise' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Items Section -->
            @if (isset($relatedItems) && $relatedItems->count() > 0)
                <div class="related-items mt-5">
                    <h3 class="section-title mb-4 text-light">You May Also Like</h3>
                    <div class="row g-4">
                        @foreach ($relatedItems as $item)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="related-item-card">
                                    <a href="{{ route('marketplace.show', $item) }}" class="text-decoration-none">
                                        <div class="card h-100 bg-dark text-light border-secondary">
                                            <div class="card-img-top-wrapper">
                                                <img src="{{ $item->images->first() ? asset('storage/' . $item->images->first()->image_path) : asset('images/default.png') }}"
                                                    class="card-img-top" alt="{{ $item->name }}">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title text-truncate text-light">{{ $item->name }}</h5>
                                                <p class="card-text fw-bold text-primary">
                                                    ${{ number_format($item->price, 2) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        body {
            background-color: #000;
            color: #fff;
        }

        .product-details {
            background-color: #000;
            color: #fff;
            min-height: 100vh;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #6c757d;
        }

        .main-image-container {
            background-color: #121212;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(255, 255, 255, 0.05);
            text-align: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid #333;
        }

        .btn-image-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            font-size: 18px;
        }

        .btn-image-nav:hover {
            background-color: rgba(0, 123, 255, 0.9);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-image-prev {
            left: 15px;
        }

        .btn-image-next {
            right: 15px;
        }

        .main-image {
            max-height: 380px;
            object-fit: contain;
        }

        .thumbnail-item {
            cursor: pointer;
            height: 80px;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid transparent;
            opacity: 0.7;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #121212;
        }

        .thumbnail-item:hover {
            opacity: 1;
        }

        .thumbnail-item.active {
            border-color: #007bff;
            opacity: 1;
        }

        .thumbnail-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .product-title {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }

        .price {
            font-size: 2rem;
            font-weight: 700;
            color: #4da3ff;
        }

        .artist-link {
            color: #4da3ff;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .artist-link:hover {
            color: #66b0ff;
            text-decoration: underline;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #333;
            color: #fff;
        }

        .description-content {
            line-height: 1.7;
            color: #ccc;
        }

        .product-details-meta {
            background-color: #121212;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1.5rem;
            border: 1px solid #333;
        }

        .meta-item {
            display: flex;
            margin-bottom: 0.5rem;
        }

        .meta-label {
            font-weight: 600;
            width: 100px;
            color: #999;
        }

        .meta-value {
            flex: 1;
            color: #fff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-outline-light:hover {
            color: #000;
        }

        .btn-cart-added {
            background-color: #4CAF50 !important;
            border-color: #4CAF50 !important;
        }

        .btn-wishlist-added {
            background-color: #FF6347 !important;
            border-color: #FF6347 !important;
            color: #fff !important;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.1);
        }

        .card-img-top-wrapper {
            height: 180px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #121212;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .related-item-card:hover .card-img-top {
            transform: scale(1.05);
        }

        @media (max-width: 767.98px) {
            .main-image-container {
                height: 300px;
            }

            .main-image {
                max-height: 280px;
            }

            .thumbnail-item {
                height: 60px;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .price {
                font-size: 1.5rem;
            }

            .btn-image-nav {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .btn-image-prev {
                left: 10px;
            }

            .btn-image-next {
                right: 10px;
            }
        }
    </style>

    <script>
        // Array of all product images
        const productImages = [
            @foreach ($merchItem->images as $image)
                "{{ asset('storage/' . $image->image_path) }}",
            @endforeach
        ];

        let currentImageIndex = 0;

        function updateMainImage(imageSrc) {
            // Update main image
            document.getElementById('main-product-image').src = imageSrc;

            // Update current index
            currentImageIndex = productImages.indexOf(imageSrc);

            // Update active thumbnail
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            thumbnails.forEach(thumb => {
                const thumbImg = thumb.querySelector('img');
                if (thumbImg.src === imageSrc) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
        }

        function navigateImage(direction) {
            if (productImages.length === 0) return;

            // Calculate new index
            currentImageIndex = (currentImageIndex + direction + productImages.length) % productImages.length;

            // Update the main image
            updateMainImage(productImages[currentImageIndex]);
        }

        // Keyboard navigation (optional - arrow keys)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                navigateImage(-1);
            } else if (e.key === 'ArrowRight') {
                navigateImage(1);
            }
        });
    </script>
@endsection
