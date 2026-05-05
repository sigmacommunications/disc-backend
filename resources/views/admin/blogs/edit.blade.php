<!-- resources/views/admin/contracts/edit.blade.php -->

@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Edit Blog</h1>

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

        <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ old('title', $blog->title) }}" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control">{{ old('description', $blog->description) }}</textarea>
            </div>

            <!-- Current Contract File -->
            @if ($blog->file_path)
                <div class="mb-3">
                    <label class="form-label">Current Blog File:</label>
                    <p>
                        <a href="{{ asset('storage/' . $blog->file_path) }}" target="_blank">View Contract</a>
                    </p>
                </div>
            @endif

             <!-- blog File Upload -->
             <div class="mb-3">
                <label for="image" class="form-label">Upload Blog File</label>
                <input type="file" class="form-control" id="image" name="image"
                    accept=".pdf,.docx,.jpg,.jpeg,.png">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('blogs.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
