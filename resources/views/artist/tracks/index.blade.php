@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Your Tracks</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters and Search -->
        <div class="row mb-3">
            <div class="col-md-4">
                <form action="{{ route('artist.tracks.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Search by title or genre"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Search</button>
                </form>
            </div>
            <div class="col-md-4">
                <form action="{{ route('artist.tracks.index') }}" method="GET">
                    <div class="input-group">
                        <label class="input-group-text" for="status">Status</label>
                        <select class="form-select" id="status" name="status" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Button to Upload New Track -->
        <a href="{{ route('artist.tracks.create') }}" class="btn btn-primary mb-3">Upload New Track</a>

        @if ($tracks->isEmpty())
            <p>You have not uploaded any tracks yet.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Album</th>
                        <th>Genre</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tracks as $track)
                        <tr>
                            <td>
                                @if ($track->cover_image_path)
                                    <img src="{{ asset('storage/' . $track->cover_image_path) }}" alt="{{ $track->title }}"
                                        width="100">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $track->title }}</td>
                            <td>
                                @if ($track->album)
                                    <a
                                        href="{{ route('artist.albums.show', $track->album->id) }}">{{ $track->album->title }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $track->genre->name ?? 'N/A' }}</td>
                            <td>{{$track->duration }}</td>
                            <td>
                                @if ($track->approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('artist.tracks.show', $track->id) }}"
                                    class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('artist.tracks.edit', $track->id) }}"
                                    class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('artist.tracks.destroy', $track->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this track?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            {{ $tracks->links() }}
        @endif
    </div>
@endsection
