@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Artist Dashboard</h1>

        <!-- Profile Section -->
        <div class="card mb-4">
            <div class="card-header">Profile Information</div>
            <div class="card-body">
                <form action="{{ route('artist.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image -->
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                        @if (!empty($artist) && $artist->profile_image)
                            <img src="{{ asset('storage/' . $artist->profile_image) }}" alt="Profile Image" width="150"
                                class="mt-2">
                        @endif
                    </div>

                    <!-- Bio -->
                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $artist->bio ?? '') }}</textarea>
                    </div>

                    <!-- Social Links -->
                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter Link</label>
                        <input type="text" class="form-control" id="twitter" name="twitter"
                               value="{{ old('twitter', $artist->twitter ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram Link</label>
                        <input type="text" class="form-control" id="instagram" name="instagram"
                               value="{{ old('instagram', $artist->instagram ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook Link</label>
                        <input type="text" class="form-control" id="facebook" name="facebook"
                               value="{{ old('facebook', $artist->facebook ?? '') }}">
                    </div>

                    <!-- Add more fields for other social platforms -->


                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Discography Section -->
        <div class="card mb-4">
            <div class="card-header">Discography</div>
            <div class="card-body">
                <a href="{{ route('artist.albums.create') }}" class="btn btn-success mb-3">Add New Album</a>
                <div class="row">
                    @if (!empty($artist) && $artist->albums->isNotEmpty())
                        @foreach ($artist->albums as $album)
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    @if ($album->cover_image)
                                        <img src="{{ asset('storage/' . $album->cover_image) }}" class="card-img-top"
                                            alt="{{ $album->title }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $album->title }}</h5>
                                        <p class="card-text">Released on:
                                            {{ $album->release_date?->format('F d, Y') ?? 'N/A' }}</p>
                                        <a href="{{ route('artist.albums.show', $album->id) }}" class="btn btn-primary">View
                                            Album</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No albums available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <div class="card mb-4">
            <div class="card-header">Upcoming Events</div>
            <div class="card-body">
                <a href="{{ route('artist.events.create') }}" class="btn btn-success mb-3">Add New Event</a>
                <ul class="list-group">
                    @if (!empty($events) && $events->isNotEmpty())
                        @foreach ($events as $event)
                            <li class="list-group-item">
                                <h5>{{ $event->title ?? 'Untitled Event' }}</h5>
                                <p>Date: {{ $event->event_date?->format('F d, Y h:i A') ?? 'Date not set' }}</p>
                                <p>Tickets: <a href="{{ $event->ticket_link }}" target="_blank">Buy Tickets</a></p>
                                <p>{{ $event->promotional_details ?? 'No details available' }}</p>
                                <a href="{{ route('artist.events.edit', $event->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            </li>
                        @endforeach
                    @else
                        <p>No upcoming events available.</p>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection
