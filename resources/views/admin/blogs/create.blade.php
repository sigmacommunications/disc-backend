
@extends('layout.app')
@section('content')
    <div class="container">
        <h1>Create New Blog</h1>

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

        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Title -->
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" placeholder="Title" class="form-control">

            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>


            <!-- blog File Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Upload Blog File</label>
                <input type="file" class="form-control" id="image" name="image"
                    accept=".pdf,.docx,.jpg,.jpeg,.png">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
