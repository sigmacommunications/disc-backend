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
    <link href="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/new logo.png') }}" />
    <title>Feeds</title>
    @include('partials.preloader-script')
</head>

<body>
    @include('partials.preloader')
    <header class="header-track">
        <div class="row align-items-center">
            <div class="col-6 d-block d-md-none">
                <a href="{{ route('home') }}"><img src="{{ asset('front_asset/images/logo.png') }}"
                        class="head-logo" /></a>
            </div>
            <div class="col-md-12 col-lg-12 col-6 d-none d-md-block">
                <nav class="navbar navbar-light navbar-expand-lg d-block p-0">
                    <div class="header-b">
                        <div class="container d-block">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="first-div">
                                        <a href="{{ route('start-selling') }}" class="start">Start Selling</a>
                                        <a href="{{ route('explore') }}" class="starta">Explore</a>
                                        <a href="{{ route('creator-tools') }}" class="starta">Creator Tools</a>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <a href="/"><img src="{{ asset('assets/images/new logo.png') }}"
                                            class="head-logo" /></a>
                                </div>
                                <div class="col-md-5">
                                    <div class="second-div">
                                        <div id="myOverlay" class="overlay">
                                            <span class="closebtn" onclick="closeSearch()" title="Close Overlay">x</span>
                                            <div class="overlay-content">
                                                <form action="#">
                                                    <input type="text" placeholder="Search.." name="search" />
                                                    <button type="submit">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <button class="openBtn" onclick="openSearch()">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                        <a href="#" class="start-shopping"><i class="fa-solid fa-cart-shopping"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container d-block ct-2">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <ul class="fourth-hd">
                                    <a href="{{ route('feeds') }}" class="{{ request()->routeIs('feeds') ? 'active' : '' }}">
                                        <li>Feed</li>
                                    </a>
                                    {{-- <a href="{{ route('tracks') }}" class="{{ request()->routeIs('tracks') ? 'active' : '' }}">
                                    <li>Tracks</li>
                                    </a> --}}
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
                                    <a href="{{ route('marketplace.index') }}"
                                        class="{{ request()->routeIs('marketplace.index') ? 'active' : '' }}">
                                        <li>Marketplace</li>
                                    </a>
                                </ul>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('register') }}" class="starta">Sign Up</a>
                                <a href="{{ route('login') }}" class="starta">Sign In</a>
                            </div>
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
<script src="
  https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
  "></script>
<script src="
  https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js
  "></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    // Track Player
    function createPlayer(name, data = {}) {
        const audio = document.createElement("audio"),
            player = document.createElement("div"),
            info = document.createElement("div"),
            controller = document.createElement("div");

        audio.hidden = true;
        audio.id = name;
        audio.src = data?.src ?? "";

        player.classList.add("player");

        // Informacao
        const title = document.createElement("h3");

        title.textContent = data?.title ?? "Uninformed";

        title.title = data?.title ?? "Uninformed";

        info.append(title);
        player.appendChild(info);

        // Controller
        const controllers = document.createElement("div"),
            imgPlay = document.createElement("img"),
            bar = document.createElement("div"),
            processBar = document.createElement("div"),
            time = document.createElement("div"),
            duration = document.createElement("span"),
            currentTime = document.createElement("span");

        imgPlay.src =
            "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAABKklEQVQ4jWNwMguzPrDvZOiZU5djCjIbNf7//89ACmaY0jff4tGj5/+heOGZU5c7STGAiZuHW4oBAeLEJEQkHj9+sXDB7NURDEQAJgYGBjE0ZXEg7Oxh63n29JXOwqwmDXzGsDAwMDzFIQdyDUNRZZrE2dNXXhib6pRjUwRywUMCDsXrLZAB74jwKk5vgbzAS4QByK5B8RbIBcokGIBskMSU/oU+IAO+kGEACEjdvf3wMcgLX0nUuOfrl2+fli1YN6F/Wt1FkAt+kqJ505qd8zQ0lYKbOksOM0AD8TcxGi9fvH5i6dy1E5aun/IWWYKQAXDngmz08nHEUADyAi4DMJyLDYBc8I9Y52I14OWL17BoJOhcbIBRU9pB0tPP0Z+bl+sqPqdiBQwMDACvUdjLFtm1SgAAAABJRU5ErkJggg==";

        bar.classList.add("bar1");

        bar.addEventListener("click", (event) => {
            let tmp = event.clientX - bar.offsetLeft,
                width = bar.style.width;

            tmp = (tmp / bar.clientWidth) * 100;

            audio.currentTime = (audio.duration / 100) * tmp;
        });

        const updatePlayer = () => {
            imgPlay.src = audio.paused ?
                "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAABKklEQVQ4jWNwMguzPrDvZOiZU5djCjIbNf7//89ACmaY0jff4tGj5/+heOGZU5c7STGAiZuHW4oBAeLEJEQkHj9+sXDB7NURDEQAJgYGBjE0ZXEg7Oxh63n29JXOwqwmDXzGsDAwMDzFIQdyDUNRZZrE2dNXXhib6pRjUwRywUMCDsXrLZAB74jwKk5vgbzAS4QByK5B8RbIBcokGIBskMSU/oU+IAO+kGEACEjdvf3wMcgLX0nUuOfrl2+fli1YN6F/Wt1FkAt+kqJ505qd8zQ0lYKbOksOM0AD8TcxGi9fvH5i6dy1E5aun/IWWYKQAXDngmz08nHEUADyAi4DMJyLDYBc8I9Y52I14OWL17BoJOhcbIBRU9pB0tPP0Z+bl+sqPqdiBQwMDACvUdjLFtm1SgAAAABJRU5ErkJggg==" :
                "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAASCAYAAABSO15qAAAAaElEQVQ4jWOgFDCC9D9+/GIhAwNDHJJZi2RkxOORzX7y5CWGGllZiXiYAf/RHSIjI86IZgCGGllZCUYmSr0wasCoAaMGQAALiPj65ds6bh4uPgYGBhcGBoY9X798+4SukBg1pAMGBgYAdXcjO7NTRb4AAAAASUVORK5CYII=";
        };

        imgPlay.addEventListener("click", () =>
            audio.paused ? audio.play() : audio.pause()
        );
        audio.addEventListener("playing", () => updatePlayer());
        audio.addEventListener("pause", () => updatePlayer());

        audio.addEventListener("timeupdate", () => {
            processBar.style.width =
                parseInt((audio.currentTime / audio.duration) * 100) + "%";
        });

        controllers.append(imgPlay);
        bar.appendChild(processBar);

        controller.append(controllers, bar, time);

        player.audio = audio;

        player.appendChild(controller);

        return player;
    }

    function ajusteTextTime(time) {
        if (isNaN(time)) {
            time = 0;
        }

        time = time.toFixed(2);

        let minutos = parseInt(time > 59 ? time / 60 : 0),
            segundos = parseInt(time % 60);

        minutos = ("00" + minutos).slice(-2);
        segundos = ("00" + segundos).slice(-2);

        return minutos + ":" + segundos;
    }

    window.onload = () => {
        const player1 = createPlayer("player_html1", {
            src: "https://pl.meln.top/mr/242971d39dd4abd59c0d7a2d5c144f73.mp3",
            img: "https://obj.the1.wiki/thecloud/temp/5945792e6a7067.jpg",
            title: "Amazing platform! Easy upload process and great community support. - Maya L. Frye",
            subTitle: "",
        });
        player1.audio.volume = 0.2;
        document.getElementById("main").appendChild(player1);

        const player2 = createPlayer("player_html2", {
            src: "https://pl.meln.top/mr/242971d39dd4abd59c0d7a2d5c144f73.mp3",
            img: "https://obj.the1.wiki/thecloud/temp/5945792e6a7067.jpg",
            title: "Game-changer for my music career. Highly recommended! - Robert N. Perez",
            subTitle: "",
        });
        player2.audio.volume = 0.2;
        document.getElementById("main1").appendChild(player2);

        // Repeat the process for player3 and player4
        const player3 = createPlayer("player_html3", {
            src: "https://pl.meln.top/mr/242971d39dd4abd59c0d7a2d5c144f73.mp3",
            img: "https://obj.the1.wiki/thecloud/temp/5945792e6a7067.jpg",
            title: "Discovering incredible music and sharing my own has never been easier. - Steven L. Blake",
            subTitle: "",
        });
        player3.audio.volume = 0.2;
        document.getElementById("main2").appendChild(player3);

        const player4 = createPlayer("player_html4", {
            src: "https://pl.meln.top/mr/242971d39dd4abd59c0d7a2d5c144f73.mp3",
            img: "https://obj.the1.wiki/thecloud/temp/5945792e6a7067.jpg",
            title: "Simple upload process and invaluable community feedback. - Kyle T. Novak",
            subTitle: "",
        });
        player4.audio.volume = 0.2;
        document.getElementById("main3").appendChild(player4);
    };
    // Track Player
</script>


</html>
