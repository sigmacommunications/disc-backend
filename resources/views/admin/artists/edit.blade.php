@extends('layout.app')

@section('content')
    <div class="container">

        <h1>{{ isset($artist) ? 'Edit' : 'Create' }} Artist</h1>

        <form action="{{ isset($artist) ? route('artists.update', $artist->id) : route('artists.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($artist))
                @method('PUT')
            @endif

            <!-- User's Name and Email -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $artist->user->name ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="{{ old('email', $artist->user->email ?? '') }}">
            </div>
            @if (isset($artist) && isset($artist->user))
                <!-- Password (only for update) -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Leave blank to keep current password">
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Leave blank to keep current password">
                </div>
            @else
                <!-- For creating a new user, include password and confirm fields -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required>
                </div>
            @endif

            <!-- Bio -->
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio">{{ old('bio', $artist->bio ?? '') }}</textarea>
            </div>

            <!-- Twitter -->
            <div class="mb-3">
                <label for="twitter" class="form-label">Twitter</label>
                <input type="text" class="form-control" id="twitter" name="twitter"
                    value="{{ old('twitter', $artist->twitter ?? '') }}">
            </div>

            <!-- Instagram -->
            <div class="mb-3">
                <label for="instagram" class="form-label">Instagram</label>
                <input type="text" class="form-control" id="instagram" name="instagram"
                    value="{{ old('instagram', $artist->instagram ?? '') }}">
            </div>

            <!-- Facebook -->
            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook</label>
                <input type="text" class="form-control" id="facebook" name="facebook"
                    value="{{ old('facebook', $artist->facebook ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload profile Image</label>
                <input type="file" class="form-control" id="image" name="profile_image"
                    accept=".jpg,.jpeg,.png">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
