@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Edit Track: {{ $track->title }}</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('artist.tracks.update', $track->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Track Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Track Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $track->title) }}" required>
            </div>

            <!-- Genre Selection -->
            <div class="mb-3">
                <label for="genre_id" class="form-label">Genre <span class="text-danger">*</span></label>
                <div class="input-group">
                    <select class="form-select" id="genre_id" name="genre_id" required>
                        <option value="">-- Select Genre --</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}"
                                {{ old('genre_id', $track->genre_id) == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Button to add new genre -->
                    <button class="btn btn-outline-secondary" type="button" id="add-genre-button">Add Genre</button>
                </div>
            </div>

            <!-- Album Selection -->
            <div class="mb-3">
                <label for="album_id" class="form-label">Album <span class="text-danger">*</span></label>
                <select class="form-select" id="album_id" name="album_id" required>
                    <option value="">-- Select Album --</option>
                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}"
                            {{ old('album_id', $track->album_id) == $album->id ? 'selected' : '' }}>
                            {{ $album->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Duration -->
            {{-- <div class="mb-3">
                <label for="duration" class="form-label">Duration (seconds) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="duration" name="duration"
                    value="{{ old('duration', $track->duration) }}" min="1" required>
            </div> --}}
            <div class="mb-3">
                <label for="duration" class="form-label">Duration (MM:SS) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="duration" name="duration"
                    value="{{ old('duration', $track->duration) }}" required>
                <small class="form-text text-muted">Enter duration in minutes and seconds, e.g., 05:30 for 5 minutes and 30
                    seconds.</small>
            </div>

            <!-- Audio File -->
            <div class="mb-3">
                <label for="audio_file" class="form-label">Audio File (optional)</label>
                <input type="file" class="form-control" id="audio_file" name="audio_file" accept=".mp3, .wav, .ogg">
                @if ($track->audio_file_path)
                    Current File:
                    <p class="mt-2">
                        <audio controls class="mt-2">
                            <source src="{{ route('artist.tracks.stream', $track->id) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        {{-- <a href="{{ asset('storage/' . $track->audio_file_path) }}"
                            target="_blank">{{ basename($track->audio_file_path) }}</a> --}}
                    </p>
                @endif
            </div>

            <!-- Cover Image -->
            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image" accept=".jpg, .jpeg, .png">
                @if ($track->cover_image_path)
                    <img src="{{ asset('storage/' . $track->cover_image_path) }}" alt="{{ $track->title }}" width="150"
                        class="mt-2">
                @endif
            </div>

            {{-- <div class="mb-3">
                <label for="royalty_amount" class="form-label">Royalty</label>
                <input type="text" class="form-control" id="royalty_amount" name="royalty_amount"
                    value="{{ old('royalty_amount', $track->royalty_amount) }}" required>
            </div>
            <div class="mb-3">
                <label for="play_count" class="form-label">Play Count</label>
                <input type="text" class="form-control" id="play_count" name="play_count"
                    value="{{ old('play_count', $track->play_count) }}" required>
            </div> --}}

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Track Description (optional)</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $track->description) }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Track</button>
        </form>
    </div>

    <!-- Modal for Adding New Genre -->
    <div class="modal fade" id="addGenreModal" tabindex="-1" aria-labelledby="addGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="add-genre-form">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Genre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="new_genre_name" class="form-label">Genre Name</label>
                            <input type="text" class="form-control" id="new_genre_name" name="new_genre_name"
                                required>
                        </div>
                        <div id="genre-error" class="text-danger"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Genre</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            Inputmask("99:99").mask("#duration");
        });
        document.getElementById('add-genre-button').addEventListener('click', function() {
            var addGenreModal = new bootstrap.Modal(document.getElementById('addGenreModal'));
            addGenreModal.show();
        });

        document.getElementById('add-genre-form').addEventListener('submit', function(e) {
            e.preventDefault();
            var genreName = document.getElementById('new_genre_name').value.trim();
            var genreError = document.getElementById('genre-error');

            if (genreName === '') {
                genreError.textContent = 'Genre name cannot be empty.';
                return;
            }

            fetch('{{ route('artist.genres.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        name: genreName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append the new genre to the select dropdown
                        var genreSelect = document.getElementById('genre_id');
                        var newOption = document.createElement('option');
                        newOption.value = data.genre.id;
                        newOption.text = data.genre.name;
                        newOption.selected = true;
                        genreSelect.add(newOption);

                        // Reset and hide the modal
                        document.getElementById('add-genre-form').reset();
                        genreError.textContent = '';
                        var addGenreModalEl = document.getElementById('addGenreModal');
                        var addGenreModal = bootstrap.Modal.getInstance(addGenreModalEl);
                        addGenreModal.hide();
                    } else {
                        genreError.textContent = data.message || 'An error occurred.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    genreError.textContent = 'An error occurred while adding the genre.';
                });
        });
    </script>
@endsection
