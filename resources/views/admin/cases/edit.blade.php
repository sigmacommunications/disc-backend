@extends('layout.app')

@section('title', 'Edit Case')

@section('content')
    <div class="container">
        <h1>Edit Case</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Please fix the following issues:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('cases.update', $case->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Artist Selection -->
            <div class="mb-3">
                <label for="artist_id" class="form-label">Artist</label>
                <select class="form-select" id="artist_id" name="artist_id" required>
                    <option value="">Select Artist</option>
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}"
                            {{ old('artist_id', $case->artist_id) == $artist->id ? 'selected' : '' }}>
                            {{ $artist->user->name }} ({{ $artist->user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Case Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Case Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $case->title) }}" required>
            </div>

            <!-- Case Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Case Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $case->description) }}</textarea>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Case Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="open" {{ old('status', $case->status) == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ old('status', $case->status) == 'in_progress' ? 'selected' : '' }}>In
                        Progress</option>
                    <option value="resolved" {{ old('status', $case->status) == 'resolved' ? 'selected' : '' }}>Resolved
                    </option>
                </select>
            </div>

            <!-- Admin Response -->
            <div class="mb-3">
                <label for="artist_response" class="form-label">Artist Response</label>
                <textarea class="form-control" id="artist_response" name="artist_response" rows="5">{{ old('artist_response', $case->artist_response) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Case</button>
            <a href="{{ route('cases.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
