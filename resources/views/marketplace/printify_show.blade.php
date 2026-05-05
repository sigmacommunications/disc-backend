@extends('layout.trending_menu')

@section('title', "DISC-{$product['title']}")
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
        color: #fff !important;
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
    }
</style>
@section('content')
    <div class="product-details">
        <div class="container py-5">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('marketplace.index') }}" class="text-light">Marketplace</a>
                    </li>
                    <li class="breadcrumb-item active text-white" aria-current="page">
                        {{ $product['title'] }}
                    </li>
                </ol>
            </nav>

            <div class="row">
                <!-- Images -->
                <div class="col-lg-6 mb-4">
                    <div class="product-gallery bg-dark rounded p-3">
                        <!-- Main Image Display -->
                        <div class="main-image-container mb-3 position-relative">
                            @if (!empty($product['images']))
                                <img src="{{ $product['images'][0]['src'] }}" class="img-fluid rounded w-100 main-image"
                                    id="mainProductImage" alt="{{ $product['title'] }}">

                                @if (count($product['images']) > 1)
                                    <button class="btn-main-image-nav btn-main-image-prev" onclick="navigateMainImage(-1)">
                                        <i class="fa fa-chevron-left"></i>
                                    </button>
                                    <button class="btn-main-image-nav btn-main-image-next" onclick="navigateMainImage(1)">
                                        <i class="fa fa-chevron-right"></i>
                                    </button>
                                @endif
                            @else
                                <img src="{{ asset('images/default.png') }}" class="img-fluid rounded w-100 main-image"
                                    id="mainProductImage" alt="{{ $product['title'] }}">
                            @endif
                        </div>

                        <!-- Thumbnails Gallery with Navigation -->
                        @if (!empty($product['images']) && count($product['images']) > 1)
                            <div class="thumbnails-wrapper position-relative">
                                <button class="thumbnail-nav-btn prev-btn" onclick="navigateMainImage(-1)">&lsaquo;</button>

                                <div class="thumbnails-container d-flex py-2">
                                    @foreach ($product['images'] as $index => $image)
                                        <div class="thumbnail-item mx-2"
                                            onclick="changeMainImage('{{ $image['src'] }}', {{ $index }})">
                                            <img src="{{ $image['src'] }}" class="img-thumbnail"
                                                id="thumb-{{ $index }}"
                                                style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;
                                {{ $index === 0 ? 'border: 2px solid #007bff;' : 'border: 2px solid transparent;' }}"
                                                data-index="{{ $index }}"
                                                alt="{{ $product['title'] }} - Image {{ $index + 1 }}">
                                        </div>
                                    @endforeach
                                </div>

                                <button class="thumbnail-nav-btn next-btn" onclick="navigateMainImage(1)">&rsaquo;</button>
                            </div>

                            <!-- Thumbnail Counter -->
                            <div class="text-center text-light mt-2">
                                <small><span id="currentImageIndex">1</span> / {{ count($product['images']) }}</small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Details -->
                <div class="col-lg-6">
                    <h1 class="product-title text-light mb-3">{{ $product['title'] }}</h1>
                    <p class="text-light-50">{!! $product['description'] !!}</p>

                    <!-- Variant selector -->
                    <form action="{{ route('marketplace.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="printify_product_id" value="{{ $product['id'] }}">
                        <div class="mb-3">
                            <label class="text-light-50 mb-1">Choose variant:</label>
                            <select name="variant_id" class="form-select">
                                @foreach ($product['variants'] as $variant)
                                    <option value="{{ $variant['id'] }}">
                                        {{ $variant['title'] }} — ${{ $variant['price'] / 100 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn add-cart btn-primary btn-lg">
                            <i class="fa fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .product-gallery {
            background-color: #1a1a1a;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .main-image-container {
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #121212;
            border-radius: 6px;
        }

        .main-image {
            max-height: 400px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .thumbnails-wrapper {
            position: relative;
            padding: 0 30px;
        }

        .thumbnails-container {
            overflow-x: auto;
            scroll-behavior: smooth;
            white-space: nowrap;
            scrollbar-width: none;
            /* Hide scrollbar for Firefox */
            -ms-overflow-style: none;
            /* Hide scrollbar for IE and Edge */
        }

        .thumbnails-container::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar for Chrome/Safari/Opera */
        }

        .thumbnail-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            z-index: 10;
            transition: background-color 0.2s;
        }

        .thumbnail-nav-btn:hover {
            background-color: rgba(0, 123, 255, 0.8);
        }

        .prev-btn {
            left: 0;
        }

        .next-btn {
            right: 0;
        }

        .thumbnail-item {
            display: inline-block;
            transition: transform 0.2s;
        }

        .img-thumbnail {
            background-color: #2c2c2c;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
            border-color: #007bff !important;
        }

        .img-thumbnail.active {
            border-color: #007bff !important;
        }

        .btn-main-image-nav {
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

        .btn-main-image-nav:hover {
            background-color: rgba(0, 123, 255, 0.9);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-main-image-prev {
            left: 15px;
        }

        .btn-main-image-next {
            right: 15px;
        }

        @media (max-width: 767.98px) {
            .btn-main-image-nav {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }

            .btn-main-image-prev {
                left: 10px;
            }

            .btn-main-image-next {
                right: 10px;
            }
        }
    </style>

    <script>
        let currentIndex = 0;
        const productImages = @json(array_column($product['images'] ?? [], 'src'));

        function changeMainImage(src, index) {
            document.getElementById('mainProductImage').src = src;
            currentIndex = index;

            // Update current image counter
            if (document.getElementById('currentImageIndex')) {
                document.getElementById('currentImageIndex').textContent = index + 1;
            }

            // Update thumbnail borders
            const thumbnails = document.querySelectorAll('.img-thumbnail');
            thumbnails.forEach((thumb, idx) => {
                if (idx === index) {
                    thumb.style.borderColor = '#007bff';
                } else {
                    thumb.style.borderColor = 'transparent';
                }
            });

            // Ensure the selected thumbnail is visible in the scroll area
            const thumbElement = document.getElementById(`thumb-${index}`);
            if (thumbElement) {
                thumbElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        }

        function navigateMainImage(direction) {
            if (productImages.length === 0) return;

            // Calculate new index with circular navigation
            currentIndex = (currentIndex + direction + productImages.length) % productImages.length;

            // Update the main image using the existing function
            changeMainImage(productImages[currentIndex], currentIndex);
        }

        function scrollThumbnails(direction) {
            const container = document.querySelector('.thumbnails-container');
            if (!container) return;

            // Calculate scroll amount based on container width
            const scrollAmount = container.offsetWidth * 0.8; // Scroll 80% of visible width

            container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }

        // Optional: Add keyboard navigation
        document.addEventListener('keydown', function(event) {
            const imagesCount = document.querySelectorAll('.thumbnail-item').length;

            if (event.key === 'ArrowRight') {
                navigateMainImage(1);
            } else if (event.key === 'ArrowLeft') {
                navigateMainImage(-1);
            }
        });
    </script>
@endsection
