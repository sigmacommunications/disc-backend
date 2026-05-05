<header class="spotify-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-2 col-4">
                <a href="{{ route('home') }}" class="sidebar-inner-a"><img
                        src="{{ asset('assets/images/new logo.png') }}" class="spotify-logo" /></a>
            </div>
            <div class="col-lg-2 col-md-1 d-none d-md-block"></div>
            <div class="col-md-6 col-lg-4 col-8">
                <div class="wrapper">
                    <div class="homeicon">
                        <a href="{{ route('start-selling') }}"><i class="fa-solid fa-house"></i></a>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search this blog">
                        <div class="input-group-append">
                            <button class="btn search-button" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-1 d-none d-md-block"></div>
            <div class="col-md-2 d-none d-md-block text-end">
                @guest
                <a href="{{ route('register') }}" class="sign-btn">Sign up</a>
                <a href="{{ route('login') }}" class="login-btn">Log in</a>
                @endguest
                @auth
                <div class="dropdown profile-picture">
                    <button class="btn dropdown-toggle">
                        @if (auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" class="profile-img" />
                    </button>
                    @else
                    <img src="{{ asset('assets/images/music-player/dp.jpg') }}" class="profile-img" /></button>
                    @endif
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </div>
</header>