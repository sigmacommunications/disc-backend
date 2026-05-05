@extends('layout.app')

@section('content')
    <div class="container">
        <h1>{{ $track->title }}</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Track Details -->
        <div class="card mb-3">
            <div class="row g-0">
                @if ($track->cover_image_path)
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $track->cover_image_path) }}" class="img-fluid rounded-start"
                            alt="{{ $track->title }}">
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $track->title }}</h5>
                        <p class="card-text"><strong>Album:</strong>
                            @if ($track->album)
                                <a
                                    href="{{ route('artist.albums.show', $track->album->id) }}">{{ $track->album->title }}</a>
                            @else
                                N/A
                            @endif
                        </p>
                        <p class="card-text"><strong>Genre:</strong> {{ $track->genre->name ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Duration:</strong> {{$track->duration }}</p>
                        <p class="card-text"><strong>Description:</strong> {{ $track->description ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Status:</strong>
                            @if ($track->approved)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </p>
                        <p class="card-text"><small class="text-muted">Uploaded on
                                {{ $track->created_at->format('F d, Y') }}</small></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audio Player -->
        <div class="mb-3">
            <h5>Listen to Track:</h5>
            <audio controls>
                <source src="{{ asset('storage/' . $track->audio_file_path) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>

        <!-- Actions -->
        <a href="{{ route('artist.tracks.edit', $track->id) }}" class="btn btn-secondary">Edit Track</a>
        <form action="{{ route('artist.tracks.destroy', $track->id) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Are you sure you want to delete this track?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Track</button>
        </form>
    </div>
@endsection
