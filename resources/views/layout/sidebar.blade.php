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
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Users -->
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Users</div>
            </a>
        </li>

        <!-- Manage Artists -->
        <li class="menu-item {{ request()->routeIs('artists.*') ? 'active' : '' }}">
            <a href="{{ route('artists.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-music"></i>
                <div data-i18n="Basic">Manage Artists</div>
            </a>
        </li>

        <!-- Track Approvals -->
        <li class="menu-item {{ request()->routeIs('admin.track-approvals.*') ? 'active' : '' }}">
            <a href="{{ route('admin.track-approvals.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-check-circle"></i>
                <div data-i18n="Basic">Track Approvals</div>
            </a>
        </li>

        <!-- Manage Contracts -->
        <li class="menu-item {{ request()->routeIs('contracts.*') ? 'active' : '' }}">
            <a href="{{ route('contracts.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Basic">Manage Contracts</div>
            </a>
        </li>

        <!-- Manage Cases -->
        <li class="menu-item {{ request()->routeIs('cases.*') ? 'active' : '' }}">
            <a href="{{ route('cases.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-briefcase"></i>
                <div data-i18n="Basic">Manage Cases</div>
            </a>
        </li>

        <!-- Royalties -->
        <li class="menu-item {{ request()->routeIs('admin.royalties.*') ? 'active' : '' }}">
            <a href="{{ route('admin.royalties.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dollar-circle"></i>
                <div data-i18n="Basic">Royalties</div>
            </a>
        </li>

        <!-- Manage Plans -->
        <li class="menu-item {{ request()->routeIs('plans.*') ? 'active' : '' }}">
            <a href="{{ route('plans.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Basic">Manage Plans</div>
            </a>
        </li>

        <!-- Support Tickets -->
        <li class="menu-item {{ request()->routeIs('support.*') ? 'active' : '' }}">
            <a href="{{ route('support.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Basic">
                    Support Tickets
                    @if ($unreadCount > 0)
                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                    @endif
                </div>
            </a>
        </li>

        <!-- manage news and blog -->
        <li class="menu-item {{ request()->routeIs('blogs.*') ? 'active' : '' }}">
            <a href="{{ route('blogs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Basic">Manage News &amp; Blog</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.merch.*') ? 'active' : '' }}">
            <a href="{{ route('admin.merch.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                <div data-i18n="Basic">Manage Merch Items</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('artist-merch.*') ? 'active' : '' }}">
            <a href="{{ route('artist-merch.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-palette"></i>
                <div data-i18n="Basic">Artist Merch Items</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin_orders.*') ? 'active' : '' }}">
            <a href="{{ route('admin_orders.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div data-i18n="Basic">Order Management</div>
            </a>
        </li>


        <!-- Log Out -->
        <li class="menu-item">
            <a class="menu-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <span class="align-middle">Log Out</span>
            </a>

            <!-- Hidden form to handle the POST request -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>

</aside>
