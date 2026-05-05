@extends('layout.app')

@section('content')
    <div class="container">
        <h1 class="mt-5">{{ isset($plan) ? 'Edit Plan' : 'Create Plan' }}</h1>

        <form action="{{ isset($plan) ? route('plans.update', $plan->id) : route('plans.store') }}" method="POST">
            @csrf
            @if (isset($plan))
                @method('PUT')
            @endif

            <!-- Name -->
            <div class="form-group">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $plan->name ?? '') }}" required>
            </div>

            <!-- Slug -->
            <div class="form-group">
                <label for="slug">Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control"
                    value="{{ old('slug', $plan->slug ?? '') }}" required>
            </div>

            <!-- Stripe Price ID -->
            <div class="form-group">
                <label for="stripe_plan">Stripe Price ID <span class="text-danger">*</span></label>
                <input type="text" name="stripe_plan" id="stripe_plan" class="form-control"
                    value="{{ old('stripe_plan', $plan->stripe_plan ?? '') }}" required>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price">Price (USD) <span class="text-danger">*</span></label>
                <input type="number" name="price" id="price" class="form-control"
                    value="{{ old('price', $plan->price ?? '') }}" required min="0" step="0.01">
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description <span class="text-danger">*</span></label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $plan->description ?? '') }}</textarea>
            </div>

            <!-- Duration -->
            <div class="form-group">
                <label for="duration">Duration <span class="text-danger">*</span></label>
                <select name="duration" id="duration" class="form-control" required>
                    <option value="mon" {{ old('duration', $plan->duration ?? '') == 'mon' ? 'selected' : '' }}>Monthly
                    </option>
                    <option value="yr" {{ old('duration', $plan->duration ?? '') == 'yr' ? 'selected' : '' }}>Yearly
                    </option>
                </select>
            </div>

            <!-- Subtitle -->
            <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" class="form-control"
                    value="{{ old('subtitle', $plan->subtitle ?? '') }}">
            </div>

            <!-- Offer Text -->
            <div class="form-group">
                <label for="offer_text">Offer Text</label>
                <input type="text" name="offer_text" id="offer_text" class="form-control"
                    value="{{ old('offer_text', $plan->offer_text ?? '') }}">
            </div>

            <!-- Included Title -->
            <div class="form-group">
                <label for="included_title">Included Title</label>
                <input type="text" name="included_title" id="included_title" class="form-control"
                    value="{{ old('included_title', $plan->included_title ?? '') }}">
            </div>

            <!-- Features -->
            <div class="form-group">
                <label for="features">Features</label>
                <div id="features-wrapper">
                    @if (isset($plan) && $plan->features->count())
                        @foreach ($plan->features as $index => $feature)
                            <div class="input-group mb-2 feature-item">
                                <input type="text" name="features[]" class="form-control"
                                    value="{{ old('features.' . $index, $feature->feature) }}" required>
                                <button type="button" class="btn btn-danger remove-feature">Remove</button>
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2 feature-item">
                            <input type="text" name="features[]" class="form-control" required>
                            <button type="button" class="btn btn-danger remove-feature">Remove</button>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-primary" id="add-feature">Add Feature</button>
            </div>

            <button type="submit" class="btn btn-success mt-3">{{ isset($plan) ? 'Update' : 'Create' }}</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addFeatureBtn = document.getElementById('add-feature');
            const featuresWrapper = document.getElementById('features-wrapper');

            addFeatureBtn.addEventListener('click', function() {
                const featureItem = document.createElement('div');
                featureItem.classList.add('input-group', 'mb-2', 'feature-item');

                featureItem.innerHTML = `
                <input type="text" name="features[]" class="form-control" required>
                <button type="button" class="btn btn-danger remove-feature">Remove</button>
            `;

                featuresWrapper.appendChild(featureItem);
            });

            featuresWrapper.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-feature')) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
@endsection
