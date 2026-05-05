@extends('layout.trending_menu')

@section('content')
    <section class="explore-1 py-5 text-white">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
                <div>
                    <h3 class="explore-a mb-1">Explore</h3>
                    <p class="text-white small mb-0">
                        {{ $tracks->count() }} curated track{{ $tracks->count() === 1 ? '' : 's' }}
                        {{ $searchTerm ? 'found for "' . $searchTerm . '"' : 'from our latest drops' }}
                    </p>
                </div>
                <div class="flex-grow-1">
                    <form action="{{ route('explore') }}" method="GET" class="explore-search-form">
                        <div class="input-group">
                            <span class="input-group-text explore-search-icon">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" name="search" id="exploreSearch" class="form-control explore-search-input"
                                placeholder="Search tracks or artists..." value="{{ old('search', $searchTerm) }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                    @if ($searchTerm)
                        <a href="{{ route('explore') }}" class="small text-decoration-underline d-inline-block mt-2">
                            Clear search
                        </a>
                    @endif
                </div>
            </div>

            <div class="row g-4" id="exploreResults">
                @forelse ($tracks as $track)
                    @php
                        $artistName = optional(optional($track->artist)->user)->name ?? 'Unknown Artist';
                        $coverImage = $track->cover_image_path
                            ? (\Illuminate\Support\Str::startsWith($track->cover_image_path, ['http://', 'https://'])
                                ? $track->cover_image_path
                                : asset('storage/' . ltrim($track->cover_image_path, '/')))
                            : asset('front_asset/images/music.jpg');
                        $albumTitle = optional($track->album)->title ?? 'Single';
                    @endphp
                    <div class="col-lg-3 col-md-4 col-sm-6 explore-card" data-title="{{ strtolower($track->title) }}"
                        data-artist="{{ strtolower($artistName) }}">
                        <div class="track-card h-100">
                            <div class="track-card__image">
                                <img src="{{ $coverImage }}" alt="{{ $track->title }} cover art">
                            </div>
                            <div class="track-card__body">
                                <h5 class="track-card__title">{{ $track->title }}</h5>
                                <p class="track-card__artist mb-1">{{ $artistName }}</p>
                                <span class="track-card__meta">{{ $albumTitle }} &bull; {{ $track->duration }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-white mb-0">
                            No tracks found{{ $searchTerm ? ' for "' . $searchTerm . '"' : '' }}.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        .explore-1 {
            background: #050505;
            min-height: 100vh;
        }

        .explore-search-form .input-group {
            max-width: 500px;
            margin-left: auto;
        }

        .explore-search-input {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid #2e2e2e;
            color: #fff;
            height: 48px;
        }

        .explore-search-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .explore-search-icon {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid #2e2e2e;
            color: #fff;
        }

        .track-card {
            background: #121212;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #1f1f1f;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .track-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .track-card__image {
            position: relative;
            padding-top: 70%;
            overflow: hidden;
        }

        .track-card__image img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .track-card__body {
            padding: 1rem;
        }

        .track-card__title {
            font-size: 1rem;
            color: #fff;
            margin-bottom: 0.25rem;
        }

        .track-card__artist {
            font-size: 0.9rem;
            color: #bbb;
        }

        .track-card__meta {
            font-size: 0.8rem;
            color: #888;
        }

        @media (max-width: 767.98px) {
            .explore-search-form .input-group {
                max-width: 100%;
            }

            .explore-1 {
                padding-top: 2rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('exploreSearch');
            const cards = document.querySelectorAll('.explore-card');

            if (!searchInput || cards.length === 0) {
                return;
            }

            searchInput.addEventListener('input', function () {
                const term = this.value.toLowerCase();

                cards.forEach(card => {
                    const matches = card.dataset.title.includes(term) || card.dataset.artist.includes(term);
                    card.classList.toggle('d-none', !matches);
                });
            });
        });
    </script>
@endsection
