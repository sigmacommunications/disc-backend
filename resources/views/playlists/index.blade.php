@extends('frontend.spotify.layout.app')

@section('content')
    <div class="playlist-wrapper">
        <div class="row">
            <!-- Create Playlist Form -->
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="my-0">Create New Playlist</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('playlists.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Playlist Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter playlist name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Create Playlist</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Playlists List -->
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="my-0">Your Playlists</h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($playlists as $playlist)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('playlists.show', $playlist->id) }}"
                                    class="text-decoration-none">{{ $playlist->name }}</a>
                                <span class="badge bg-primary rounded-pill">{{ $playlist->tracks->count() }} Tracks</span>
                            </li>
                        @empty
                            <li class="list-group-item">No playlists found. Create one above!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
