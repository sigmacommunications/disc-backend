@extends('layout.trending_menu')
@section('title', $track->title)
@section('content')
    @php
        $artistName = optional(optional($track->artist)->user)->name ?? 'Unknown Artist';
        $artistUserId = optional(optional($track->artist)->user)->id;
        $coverImage = $track->cover_image_path
            ? (\Illuminate\Support\Str::startsWith($track->cover_image_path, ['http://', 'https://'])
                ? $track->cover_image_path
                : asset('storage/' . ltrim($track->cover_image_path, '/')))
            : asset('front_asset/images/music.jpg');
    @endphp

    <section class="blogs-three">
        <section class="b3sec1">
            <div class="container">
                <h1>TRACK DETAILS</h1>
                <p>Discover the story behind the music</p>
            </div>
        </section>
        <section class="b3sec2">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-md-8">
                        <div class="hello">
                            <div class="imgdiv">
                                <img src="{{ $coverImage }}" alt="{{ $track->title }} cover art">
                            </div>
                            <div class="content">
                                <h2>{{ $track->title }}</h2>
                                <p class="mb-2">
                                    @if ($artistUserId)
                                        <a href="{{ route('artists.details', $artistUserId) }}" class="text-decoration-none">
                                            {{ $artistName }}
                                        </a>
                                    @else
                                        {{ $artistName }}
                                    @endif
                                </p>
                                @if ($track->description)
                                    <p>{{ $track->description }}</p>
                                @endif
                                <div class="d-flex flex-wrap gap-3 mt-3">
                                    <button type="button" class="btn btn-primary" onclick="playSong({{ $track->id }})">
                                        <i class="fa-solid fa-play"></i> Play
                                    </button>
                                    @if ($track->audio_file_path)
                                        <audio controls class="track-detail-audio">
                                            <source src="{{ asset('storage/' . $track->audio_file_path) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($relatedTracks->isNotEmpty())
                            <div class="latest-events mt-4">
                                <h2>More from this Album</h2>
                                <ul class="list-unstyled">
                                    @foreach ($relatedTracks as $relatedTrack)
                                        <li class="mb-2">
                                            <a href="{{ route('tracks.details', $relatedTrack->id) }}" class="text-decoration-none">
                                                <i class="fa-solid fa-music"></i>
                                                {{ $relatedTrack->title }}
                                                <span class="text-muted small">
                                                    &mdash; {{ optional(optional($relatedTrack->artist)->user)->name ?? 'Unknown Artist' }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="tracks">
                            <h4>Track Info</h4>
                            <ul class="list-unstyled">
                                <li><strong>Album:</strong> {{ optional($track->album)->title ?? 'Single' }}</li>
                                <li><strong>Genre:</strong> {{ optional($track->genre)->name ?? 'N/A' }}</li>
                                <li><strong>Duration:</strong> {{ $track->duration ?? 'N/A' }}</li>
                                <li><strong>Plays:</strong> {{ number_format($track->plays_count) }}</li>
                                <li><strong>Likes:</strong> {{ number_format($track->likes_count) }}</li>
                                @if ($track->is_explicit)
                                    <li><span class="badge bg-warning text-dark">Explicit</span></li>
                                @endif
                                <li><strong>Released:</strong> {{ $track->created_at->format('F d, Y') }}</li>
                            </ul>
                        </div>

                        @if ($track->tags->isNotEmpty())
                            <div class="tracks mt-4">
                                <h4>Tags</h4>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($track->tags as $tag)
                                        <a href="{{ route('trending', ['tag' => $tag->id]) }}" class="badge bg-secondary text-decoration-none">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </section>

    <style>
        .track-detail-audio {
            max-width: 280px;
            height: 38px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        function playSong(trackID) {
            localStorage.setItem('trackID', trackID);
            window.location.href = '{{ route('start-selling') }}';
        }
    </script>
@endsection
