<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link href="
    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
    " rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/new logo.png') }}" />
    @include('partials.preloader-script')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <title>Creator Tools</title>
</head>

<body style="background: #000">
    @include('partials.preloader')
    <section class="selling-main">
        <div class="container-fluid p-0">
            <header class="header">
                <nav class="navbar navbar-dark navbar-expand-lg">
                    <div class="container d-block">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-6">
                                <a href="/"><img src="{{ asset('assets/images/new logo.png') }}"
                                        class="creater-logo" /></a>
                            </div>
                            <div class="col-md-6 d-none d-md-block">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-center">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('feeds') }}">Feed</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="{{ route('tracks') }}">Tracks</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('trending') }}">Trending</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('feature') }}">Feature</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('marketplace.index') }}">Marketplace</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-3 d-none d-md-block text-end">
                                <a href="{{ route('register') }}" class="sign-btn">Sign up</a>
                                <a href="{{ route('login') }}" class="login-btn">Log in</a>
                            </div>
                            <div class="col-6 d-lg-none d-md-none d-block">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="offcanvas offcanvas-end bg-secondary secondary-1" id="navbarOffcanvas" tabindex="-1"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <a href="{{ route('home') }}"><img src="{{ asset('front_asset/images/logo.png') }}"
                                class="head-logo" /></a>
                        <button type="button" class="btn-close btn-close-white text-reset"
                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <div class="nav-up">
                                <a href="{{ route('feeds') }}">
                                    <li>Feed</li>
                                </a>
                                <a href="{{ route('trending') }}">
                                    <li>Trending</li>
                                </a>
                                <a href="{{ route('feature') }}">
                                    <li>Feature</li>
                                </a>
                                <a href="{{ route('most-liked') }}">
                                    <li>Most Liked</li>
                                </a>
                                <a href="{{ route('subscription.index') }}">
                                    <li>Subscription</li>
                                </a>
                                <a href="{{ route('artists.list') }}">
                                    <li>Artists</li>
                                </a>
                                <a href="{{ route('marketplace.index') }}"
                                    class="{{ request()->routeIs('marketplace.index') ? 'active' : '' }}">
                                    <li>Marketplace</li>
                                </a>
                                <a href="{{ route('start-selling') }}" class="starta">Start Selling</a>
                                <a href="{{ route('explore') }}" class="starta">Explore</a>
                                <a href="{{ route('creator-tools') }}" class="starta">Creator Tools</a>
                                @guest
                                    <a href="{{ route('register') }}" class="starta">Sign Up</a>
                                    <a href="{{ route('login') }}" class="starta">Sign In</a>
                                @endguest
                                @auth
                                    @php
                                        $cartItems = auth()->user()->cartItems->pluck('id')->toArray();
                                        $wishlist = auth()->user()->wishlist->pluck('id')->toArray();
                                    @endphp
                                    <a href="{{ route('orders.index') }}" class="starta">
                                        Orders
                                    </a>
                                    <a href="{{ route('wishlist.index') }}" class="starta">Wishlist
                                        @if (count($wishlist) > 0)
                                            <span class="badge bg-primary">
                                                {{ count($wishlist) }}
                                            </span>
                                        @endif
                                    </a>
                                    <a href="{{ route('cart.index') }}" class="start-shopping shop1">Cart
                                        @if (count($cartItems) > 0)
                                            <span class="badge bg-primary">
                                                {{ count($cartItems) }}
                                            </span>
                                        @endif
                                    </a>
                                @endauth
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
                        </div>
                    </div>
                </nav>
            </header>





            @yield('content')

            
    @include('partials.footer')

        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
<script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js
"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elms = document.getElementsByClassName('splide');

        for (var i = 0; i < elms.length; i++) {
            new Splide(elms[i], {
                type: 'loop',
                drag: 'free',
                focus: 'center',
                perPage: 4,
                autoScroll: {
                    speed: 0.5,
                    pauseOnHover: false,
                    pauseOnFocus: false,
                },
                breakpoints: {
                    700: {
                        perPage: 1,
                    },
                    1024: {
                        perPage: 3,
                    }
                }
            }).mount(window.splide.Extensions);
        }
    });
</script>
<script>
    var audio1 = document.getElementById("audio_5f51b38");

    function toggleAudio(action) {
        if (action === 'play') {
            audio1.play();
            document.getElementById("lbl-btn-play").classList.add("active");
        } else if (action === 'pause') {
            audio1.pause();
            document.getElementById("lbl-btn-pause").classList.add("active");
        }
    }
</script>

</html>

