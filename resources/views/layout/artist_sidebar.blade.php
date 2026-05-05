<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('front_asset/images/logo.png') }}" class="w-75" />
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ">Disc</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('artist.dashboard') ? 'active' : '' }}">
            <a href="{{ route('artist.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Events -->
        <li class="menu-item {{ request()->routeIs('artist.events.*') ? 'active' : '' }}">
            <a href="{{ route('artist.events.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Basic">Events</div>
            </a>
        </li>

        <!-- Albums -->
        <li class="menu-item {{ request()->routeIs('artist.albums.*') ? 'active' : '' }}">
            <a href="{{ route('artist.albums.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-album"></i>
                <div data-i18n="Basic">Albums</div>
            </a>
        </li>

        <!-- Tracks -->
        <li class="menu-item {{ request()->routeIs('artist.tracks.*') ? 'active' : '' }}">
            <a href="{{ route('artist.tracks.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-music"></i>
                <div data-i18n="Basic">Tracks</div>
            </a>
        </li>

        <!-- Cases -->
        <li class="menu-item {{ request()->routeIs('artist.cases.*') ? 'active' : '' }}">
            <a href="{{ route('artist.cases.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div data-i18n="Basic">
                    Cases
                    @if (auth()->user()->artist && auth()->user()->artist->casesCount->count() > 0)
                        <span class="badge badge-center rounded-pill bg-primary">
                            {{ auth()->user()->artist->casesCount->count() }}
                        </span>
                    @endif
                </div>
            </a>
        </li>

        <!-- Transparency Reports -->
        <li class="menu-item {{ request()->routeIs('artist.reports.*') ? 'active' : '' }}">
            <a href="{{ route('artist.reports.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div data-i18n="Basic">Transparency Reports</div>
            </a>
        </li>

        <!-- Contact Support -->
        <li class="menu-item {{ request()->routeIs('artist.support.*') ? 'active' : '' }}">
            <a href="{{ route('artist.support.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Basic">
                    Contact Support
                    @if ($unreadCount > 0)
                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                    @endif
                </div>
            </a>
        </li>

        <!-- Merchandise Store -->
        <li class="menu-item {{ request()->routeIs('artist.merch.*') ? 'active' : '' }}">
            <a href="{{ route('artist.merch.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Basic">Merchandise Store</div>
            </a>
        </li>

        <!-- Log Out -->
        <li class="menu-item">
            <a class="menu-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <span class="align-middle">Log Out</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

</aside>
