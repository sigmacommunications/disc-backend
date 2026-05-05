@extends('layout.app')

@section('content')
    <div class="container">
        <h1>{{ $album->title }}</h1>
        <p>Release Date: {{ $album->release_date->format('F d, Y') }}</p>

        @if ($album->cover_image)
            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="Cover Image" width="300">
        @endif

        <a href="{{ route('artist.albums.edit', $album->id) }}" class="btn btn-secondary mt-3">Edit Album</a>

        <h3 class="mt-4">Tracks</h3>
        <ul class="list-group">
            @foreach ($album->tracks as $track)
                @if ($track->approved)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $track->title }}</strong> - {{ $track->genre->name }}
                            <span class="badge bg-secondary ms-2">{{$track->duration }}</span>
                        </div>
                        <div>
                            <a href="{{ route('artist.tracks.show', $track->id) }}" class="btn btn-info btn-sm">Stream</a>
                                <a href="{{ route('artist.tracks.edit', $track->id) }}"
                                    class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('artist.tracks.destroy', $track->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                        </div>
                    </li>
                    @else
                    <p class="text-center">
                        No approved track found.
                    </p>
                @endif
            @endforeach
        </ul>
    </div>
@endsection
