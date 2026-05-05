@extends('layout.app')

@section('content')
    <div class="container">
        <h2>{{ isset($merchItem) ? 'Edit' : 'Create' }} Merch Item</h2>
        <form action="{{ isset($merchItem) ? route('admin.merch.update', $merchItem) : route('admin.merch.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($merchItem))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="user_id" class="form-label">Admin</label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
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
                <input type="file" class="form-control" id="images" accept="image/*" name="images[]" multiple>

                @if (isset($merchItem) && $merchItem->images->count() > 0)
                    <div class="mt-2">
                        <h5>Existing Images:</h5>
                        @foreach ($merchItem->images as $image)
                            @php
                                $path = $image->image_path;
                                $src = Str::startsWith($path, ['http://', 'https://'])
                                    ? $path
                                    : asset("storage/{$path}");
                            @endphp

                            <img src="{{ $src }}" class="img-thumbnail" width="100" height="100"
                                alt="Merch Image">
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Printify Product Toggle Switch -->
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="printifyToggle" name="is_printify_product"
                    value="1"
                    {{ old('is_printify_product', isset($merchItem) ? (!empty($merchItem->printify_product_id) ? 'checked' : '') : '') }}>
                <label class="form-check-label" for="printifyToggle">Printify Product</label>
            </div>

            <div id="loader" style="display: none;">
                <span>Loading products...</span>
            </div>

            <!-- Printify Product Dropdown -->
            <div class="mb-3" id="printifyProductIdContainer" style="display: none; transition: opacity 0.3s ease;">
                <label for="printify_product_id" class="form-label">Select Printify Product</label>
                <select class="form-control select2" id="printify_product_id" name="printify_product_id">
                    <option value="">-- Select Product --</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($merchItem) ? 'Update' : 'Create' }}</button>
        </form>
    </div>

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.getElementById('printifyToggle');
            const container = document.getElementById('printifyProductIdContainer');
            const select = document.getElementById('printify_product_id');
            const loader = document.getElementById('loader');

            toggle.addEventListener('change', function() {
                if (this.checked) {
                    // Show loader
                    loader.style.display = 'block';

                    // AJAX request to fetch products
                    fetch('{{ route('admin.printify.products') }}')
                        .then(response => response.json())
                        .then(data => {
                            // Clear old options
                            select.innerHTML = '<option value="">-- Select Product --</option>';

                            // Add new options
                            data.forEach(product => {
                                const option = document.createElement('option');
                                option.value = product.id;
                                option.textContent = product.title;
                                select.appendChild(option);
                            });

                            // Show dropdown, hide loader
                            container.style.display = 'block';
                            loader.style.display = 'none';

                            $('.select2').select2();
                        })
                        .catch(error => {
                            console.error('Error fetching products:', error);
                            loader.style.display = 'none';
                        });
                } else {
                    // Hide dropdown, clear selection
                    container.style.display = 'none';
                    select.innerHTML = '<option value="">-- Select Product --</option>';
                }
            });
        });
    </script>
@endsection
@endsection
