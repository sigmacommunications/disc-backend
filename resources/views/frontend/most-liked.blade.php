@extends('layout.trending_menu')

@section('content')
    <section class="liked">
        <!-- Hero Section -->
        <div class="liked-1">
            <div class="container">
                <h3 class="liked1-a">TEE GRIZZLEY - FLOATERS [OFFICIAL VIDEO]</h3>
                <div class="liked1-inner">
                    <img src="{{ asset('assets/images/liked/home-a.png') }}" class="home-img" alt="Featured Image 1" />
                    <img src="{{ asset('assets/images/liked/home-b.png') }}" class="home-img" alt="Featured Image 2" />
                    <img src="{{ asset('assets/images/liked/home-c.png') }}" class="home-img" alt="Featured Image 3" />
                    <img src="{{ asset('assets/images/liked/home-d.png') }}" class="home-img" alt="Featured Image 4" />
                </div>
            </div>
        </div>

        <!-- Profile Section -->
        {{-- <div class="liked-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="liked2-inner">
                        <img src="{{ asset('assets/images/liked/liked-profile.png') }}"
                             class="liked-profile-img"
                             alt="Music Profile" />
                        <div class="liked2-inner-1">
                            <h3 class="liked2-a">Music</h3>
                            <h3 class="liked2-b">120M Subscribers</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    @auth
                        <a href="#" class="subscribe-btn">Subscribe</a>
                        <a href="#" class="search-btn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="login-btn">Login to Subscribe</a>
                    @endauth
                </div>
            </div>
        </div>
    </div> --}}

        <!-- Liked Tracks Section -->
        <div class="liked-3">
            <div class="container">
                @auth
                    <div class="section-header">
                        <h2 class="section-title">Your Liked Tracks</h2>
                        <p class="section-subtitle">{{ $tracks->count() }} tracks found</p>
                    </div>

                    <div class="liked3-inner-1">
                        @forelse ($tracks as $track)
                            <div class="liked-3inner">
                                <div class="track-image-wrapper">
                                    <img src="{{ asset('storage/' . $track->cover_image_path) }}" class="music1-img"
                                        alt="{{ $track->title }} Cover" />
                                    <div class="play-overlay">
                                        <i class="fa-solid fa-play"></i>
                                    </div>
                                </div>
                                <div class="track-info">
                                    <h3 class="liked3-a">{{ $track->title }}</h3>
                                    <h3 class="liked3-b">
                                        {{ $track->artist->name }} &bull;
                                        <span class="likes-count">{{ number_format($track->likes_count) }} Likes</span>
                                    </h3>
                                    <div class="track-actions">
                                        <a href="{{ route('track.play', $track->id) }}" class="play-btn">
                                            <i class="fa-solid fa-play"></i> Play
                                        </a>
                                        <button class="like-btn active" data-track-id="{{ $track->id }}">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                        <button class="share-btn">
                                            <i class="fa-solid fa-share"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa-solid fa-heart"></i>
                                </div>
                                <h3>No liked tracks yet</h3>
                                <p>Start exploring music and like your favorite tracks!</p>
                                <a href="{{ route('discover') }}" class="discover-btn">Discover Music</a>
                            </div>
                        @endforelse
                    </div>
                @else
                    <div class="auth-required">
                        <div class="auth-message">
                            <i class="fa-solid fa-lock"></i>
                            <h3>Authentication Required</h3>
                            <p>Please log in to view your liked tracks and access music features.</p>
                            <div class="auth-actions">
                                <a href="{{ route('login') }}" class="login-btn">Login</a>
                                <a href="{{ route('register') }}" class="register-btn">Sign Up</a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </section>

    <style>
        /* Hero Section Styles */
        .liked-1 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 0;
            color: white;
        }

        .liked1-a {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .liked1-inner {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .home-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .home-img:hover {
            transform: scale(1.05);
        }

        /* Profile Section Styles */
        .liked-2 {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .liked2-inner {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .liked-profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
        }

        .liked2-a {
            font-size: 1.8rem;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        .liked2-b {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .subscribe-btn,
        .login-btn {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .subscribe-btn:hover,
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
            color: white;
            text-decoration: none;
        }

        .search-btn {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 12px;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Tracks Section Styles */
        .liked-3 {
            background: #1a1a1a;
            min-height: 60vh;
            padding: 40px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
        }

        .section-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
        }

        .liked3-inner-1 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .liked-3inner {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .liked-3inner:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .track-image-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .music1-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .liked-3inner:hover .play-overlay {
            opacity: 1;
        }

        .play-overlay i {
            color: white;
            font-size: 1.5rem;
        }

        .track-info {
            flex: 1;
        }

        .liked3-a {
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .liked3-b {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
        }

        .likes-count {
            color: #ff6b6b;
            font-weight: 500;
        }

        .track-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .play-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .play-btn:hover {
            transform: scale(1.05);
            color: white;
            text-decoration: none;
        }

        .like-btn,
        .share-btn {
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: rgba(255, 255, 255, 0.7);
            padding: 8px 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .like-btn.active {
            color: #ff6b6b;
            border-color: #ff6b6b;
        }

        .like-btn:hover,
        .share-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Empty State Styles */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.8);
        }

        .empty-icon {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .discover-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .discover-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Authentication Required Styles */
        .auth-required {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }

        .auth-message {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            max-width: 400px;
        }

        .auth-message i {
            font-size: 3rem;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .auth-message h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .auth-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 25px;
        }

        .register-btn {
            background: transparent;
            color: white;
            padding: 12px 24px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .liked1-a {
                font-size: 1.8rem;
            }

            .liked1-inner {
                gap: 15px;
            }

            .home-img {
                width: 100px;
                height: 100px;
            }

            .liked3-inner-1 {
                grid-template-columns: 1fr;
            }

            .liked-3inner {
                flex-direction: column;
                text-align: center;
            }

            .track-actions {
                justify-content: center;
            }

            .auth-actions {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
@endsection
