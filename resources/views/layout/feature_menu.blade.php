<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.7/mediaelementplayer.min.css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/new logo.png') }}" />
    <title>Feature Page</title>
    @include('partials.preloader-script')
</head>

<body>
    @include('partials.preloader')
    <header class="header-sound">
        <div class="row align-items-center">
            <div class="col-6 d-block d-md-none">
                <a href="{{ route('home') }}"><img src="{{ asset('front_asset/images/logo.png') }}"
                        class="head-logo" /></a>
            </div>
            <div class="col-md-12 col-lg-12 col-6 d-none d-md-block">
                <nav class="navbar navbar-light navbar-expand-lg d-block p-0">
                    <div class="header-b header-c">
                        <div class="container d-block">
                        <div class="row align-items-center">
                            <div class="col-lg-1 col-md-2 text-center">
                                <a href="/"><img src="{{ asset('assets/images/new logo.png') }}"
                                        class="head-logo w-75" /></a>
                            </div>
                        <div class="col-lg-4 col-md-3 d-none d-lg-flex d-md-none">
                            {{-- <div class="form-div1">
                                <form action="">
                                    <div class="p-1 bg-dark rounded rounded-pill shadow-sm">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button id="button-addon2" type="submit" class="btn">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                            <input type="search" placeholder="What're you looking for?"
                                                aria-describedby="button-addon2" class="form-control border-0" />
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                        <div class="col-lg-2 col-md-5 text-end">
                            <a href="{{ route('explore') }}" class="start1">Explore</a>
                            <a href="{{ route('creator-tools') }}" class="starta">Creator Tools</a>
                        </div>
                        <div class="col-md-5">
                            <div class="second-div">
                                <a href="{{ route('register') }}" class="starta">Sign Up</a>
                                <a href="{{ route('login') }}" class="starta">Sign In</a>
                                <a href="{{ route('start-selling') }}" class="start">Start Selling</a>
                                <a href="#" class="start-shopping"><i class="fa-solid fa-cart-shopping"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid d-block ct-3 ct-4">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-12">
                        <ul class="fifth-hd">
                            <a href="{{ route('feeds') }}">
                                <li>Feed</li>
                            </a>
                            {{-- <a href="{{ route('tracks') }}">
                                <li>Tracks</li>
                            </a> --}}
                            <a href="{{ route('trending') }}">
                                <li>Trending</li>
                            </a>
                            <a href="{{ route('feature') }}" class="active">
                                <li>Feature</li>
                            </a>
                            <a href="{{ route('most-liked') }}">
                                <li>Most Liked</li>
                            </a>
                            <a href="{{ route('subscription.index') }}">
                                <li>Subscription</li>
                            </a>
                            <a href="{{ route('marketplace.index') }}"
                                class="{{ request()->routeIs('marketplace.index') ? 'active' : '' }}">
                                <li>Marketplace</li>
                            </a>
                        </ul>
                    </div>
                    <div class="col-md-4 text-end"></div>
                </div>
            </div>
            </nav>
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
    </header>

    @yield('content')



    @include('partials.footer')

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.2.7/mediaelement-and-player.min.js"></script>
<script>
    var audio = {
        init: function() {
            var $that = this;
            $(function() {
                $that.components.media();
            });
        },
        components: {
            media: function(target) {
                var media = $(
                    "audio.fc-media",
                    target !== undefined ? target : "body"
                );
                if (media.length) {
                    media.mediaelementplayer({
                        audioHeight: 40,
                        features: [
                            "playpause",
                            "current",
                            "duration",
                            "progress",
                            "volume",
                            "tracks",
                            "fullscreen",
                        ],
                        alwaysShowControls: true,
                        timeAndDurationSeparator: "<span></span>",
                        iPadUseNativeControls: true,
                        iPhoneUseNativeControls: true,
                        AndroidUseNativeControls: true,
                    });
                }
            },
        },
    };
    audio.init();
</script>

<script>
    (function() {
        "use strict";

        var carousel = document.getElementsByClassName("carousel")[0],
            slider = carousel.getElementsByClassName("carousel__slider")[0],
            items = carousel.getElementsByClassName("carousel__slider__item"),
            prevBtn = carousel.getElementsByClassName("carousel__prev")[0],
            nextBtn = carousel.getElementsByClassName("carousel__next")[0];

        var width,
            height,
            totalWidth,
            margin = 20,
            currIndex = 0,
            interval,
            intervalTime = 5000;

        function init() {
            resize();
            move(Math.floor(items.length / 2));
            bindEvents();

            timer();
        }

        function resize() {
            (width = Math.max(window.innerWidth * 0.25, 275)),
            (height = window.innerHeight * 0.5),
            (totalWidth = width * items.length);

            slider.style.width = totalWidth + "px";

            for (var i = 0; i < items.length; i++) {
                let item = items[i];
                item.style.width = width - margin * 2 + "px";
                item.style.height = height + "px";
            }
        }

        function move(index) {
            if (index < 1) index = items.length;
            if (index > items.length) index = 1;
            currIndex = index;

            for (var i = 0; i < items.length; i++) {
                let item = items[i],
                    box = item.getElementsByClassName("item__3d-frame")[0];
                if (i == index - 1) {
                    item.classList.add("carousel__slider__item--active");
                    box.style.transform = "perspective(1200px)";
                } else {
                    item.classList.remove("carousel__slider__item--active");
                    box.style.transform =
                        "perspective(1200px) rotateY(" +
                        (i < index - 1 ? 40 : -40) +
                        "deg)";
                }
            }

            slider.style.transform =
                "translate3d(" +
                (index * -width + width / 2 + window.innerWidth / 2) +
                "px, 0, 0)";
        }

        function timer() {
            clearInterval(interval);
            interval = setInterval(() => {
                move(++currIndex);
            }, intervalTime);
        }

        function bindEvents() {
            window.onresize = resize;
        }

        init();
    })();
</script>

<script>
    $(document).ready(function() {
        $(".music-player1").each(function(index) {
            var audio = $(this).find(".audio-element")[0];

            $(this)
                .find(".start-button")
                .click(function() {
                    audio.play();
                });

            $(this)
                .find(".stop-button")
                .click(function() {
                    audio.pause();
                    audio.currentTime = 0;
                });

            $(this)
                .find(".reset-button")
                .click(function() {
                    audio.currentTime = 0;
                });
        });
    });
</script>

</html>

