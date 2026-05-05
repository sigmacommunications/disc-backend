@extends('layout.app')

@section('content')
    <div class="container">
        <h2>{{ isset($merchItem) ? 'Edit' : 'Create' }} Merch Item</h2>
        <form action="{{ isset($merchItem) ? route('artist.merch.update', $merchItem) : route('artist.merch.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($merchItem))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="artist_id" class="form-label">Artist</label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                <input type="hidden" name="user_id" value="{{ Auth::user()->artist->id }}">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Merch Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $merchItem->name ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="descriptions" name="description">{{ old('description', $merchItem->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price"
                    value="{{ old('price', $merchItem->price ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Images</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>

                @if (isset($merchItem) && $merchItem->images->count() > 0)
                    <div class="mt-2">
                        <h5>Existing Images:</h5>
                        @foreach ($merchItem->images as $image)
                            <img src="{{ asset("storage/{$image->image_path}") }}" class="img-thumbnail" width="100"
                                height="100">
                        @endforeach
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($merchItem) ? 'Update' : 'Create' }}</button>
        </form>
    </div>
@endsection
