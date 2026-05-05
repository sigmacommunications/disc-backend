@extends('layout.app')

@section('title', 'Create New Case')

@section('content')
    <div class="container">
        <h1>Create New Case</h1>

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

        <form action="{{ route('cases.store') }}" method="POST">
            @csrf

            <!-- Artist Selection -->
            <div class="mb-3">
                <label for="artist_id" class="form-label">Artist</label>
                <select class="form-select" id="artist_id" name="artist_id" required>
                    <option value="">Select Artist</option>
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ $artist->user->name }} ({{ $artist->user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Case Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Case Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                    required>
            </div>

            <!-- Case Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Case Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create Case</button>
            <a href="{{ route('cases.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
