@extends('layout.trending_menu')
@section('title', 'Artists')
@section('content')
    <section class="blogs-one">
        <section class="b1sec1">
            <h1 class="hero-title">
                <span class="highlight">DISCOVER</span> TALENTED ARTISTS
            </h1>
            <p class="hero-description">
                Explore our curated collection of amazing artists and their inspiring work.
                Connect with creative minds and discover unique artistic perspectives.
            </p>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $users->count() }}</span>
                    <span class="stat-label">Featured Artists</span>
                </div>
            </div>
        </section>
        <section class="artists-grid">
            <div class="container">
                <div class="section-header">
                    <h2>Meet Our Artists</h2>
                    <p>Talented individuals creating extraordinary art</p>
                </div>

                <div class="row">
                    @foreach ($users as $user)
                        @if ($user->artist)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="artist-card">
                                    <a href="{{ route('artists.details', $user->id) }}" class="artist-link">
                                        <div class="artist-image-container">
                                            <img src="{{ asset('storage/' . $user->profile_image) }}"
                                                alt="{{ $user->name }}" class="artist-image">
                                            <div class="image-overlay">
                                                <span class="view-profile">View Profile</span>
                                            </div>
                                        </div>

                                        <div class="artist-info">
                                            <h3 class="artist-name">{{ $user->name }}</h3>
                                            <p class="artist-bio">{{ Str::limit($user->artist->bio, 120) }}</p>

                                            <div class="artist-meta">
                                                <span class="artist-badge">Artist</span>
                                                <span class="view-more">Learn More →</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if ($users->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">🎨</div>
                        <h3>No Artists Yet</h3>
                        <p>Check back soon for amazing artists and their work!</p>
                    </div>
                @endif
            </div>
        </section>
    </section>
    <style>
        /* Hero Section Styles */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .highlight {
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffd700;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Artists Grid Styles */
        .artists-grid {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.1rem;
            color: #666;
        }

        /* Artist Card Styles */
        .artist-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .artist-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .artist-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .artist-image-container {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .artist-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .artist-card:hover .artist-image {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .artist-card:hover .image-overlay {
            opacity: 1;
        }

        .view-profile {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .artist-info {
            padding: 1.5rem;
        }

        .artist-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .artist-bio {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .artist-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .artist-badge {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .view-more {
            color: #667eea;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .artists-grid {
                padding: 50px 0;
            }

            .hero-section {
                padding: 60px 0;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }

            .artist-card {
                margin-bottom: 2rem;
            }
        }
    </style>
@endsection
