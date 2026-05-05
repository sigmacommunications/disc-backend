@extends('layout.app')
@section('title', 'Edit Merch Item')
@section('content')
    <div class="container">
        <h2>Edit Merch Item</h2>
        <form action="{{ route('artist-merch.update', $merchItem) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Merch Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $merchItem->name }}">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="descriptions" name="description">{{ $merchItem->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $merchItem->price }}">
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Add More Images</label>
                @foreach ($merchItem->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="" width="50">
                @endforeach

                <input type="file" class="form-control" id="images" accept="image/*" name="images[]" multiple>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
