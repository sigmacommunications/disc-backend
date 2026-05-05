@extends('frontend.spotify.layout.app')

@section('content')
    <div class="track-wrapper">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h2 class="mb-0">{{ $playlist->name }}</h2>
            </div>
            <div class="card-body">
                <p class="lead">{{ $playlist->description }}</p>

                <!-- Tracks List -->
                <h4 class="mt-4">Tracks</h4>
                @if ($playlist->tracks->isEmpty())
                    <p>No tracks in this playlist yet.</p>
                @else
                    <ul class="list-group mb-4">
                        @foreach ($playlist->tracks as $track)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $track->title }}</strong> by {{ $track->artist->user->name }}
                                </div>
                                <!-- Optional: Add buttons for removing tracks or other actions -->
                                {{-- <button class="btn btn-sm btn-danger">Remove</button>  --}}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Add Track Form -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add a New Track</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('playlists.addTrack', $playlist->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="track_id" class="form-label">Select Track</label>
                                <select class="form-select" id="track_id" name="track_id" required>
                                    <option selected disabled value="">Choose a track...</option>
                                    @foreach (App\Models\Track::all() as $track)
                                        <option value="{{ $track->id }}">{{ $track->title }} by
                                            {{ $track->artist->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add Track</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
