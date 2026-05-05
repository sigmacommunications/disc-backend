@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Edit Album: {{ $album->title }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('artist.albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Album Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $album->title) }}" required>
            </div>

            <!-- Release Date -->
            <div class="mb-3">
                <label for="release_date" class="form-label">Release Date</label>
                <input type="date" class="form-control" id="release_date" name="release_date"
                    value="{{ old('release_date', $album->release_date->format('Y-m-d')) }}">
            </div>

            <!-- Cover Image -->
            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*">
                @if ($album->cover_image)
                    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="Cover Image" width="150"
                        class="mt-2">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Album</button>
        </form>
    </div>
@endsection
