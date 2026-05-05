@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Your Albums</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to Create New Album -->
        <a href="{{ route('artist.albums.create') }}" class="btn btn-primary mb-3">Add New Album</a>

        @if ($albums->isEmpty())
            <p>You have not created any albums yet.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Release Date</th>
                        <th>Number of Tracks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($albums as $album)
                        <tr>
                            <td>
                                @if ($album->cover_image)
                                    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}"
                                        width="100">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $album->title }}</td>
                            <td>{{ $album->release_date ? $album->release_date->format('F d, Y') : 'N/A' }}</td>
                            <td>{{ $album->tracks()->count() }}</td>
                            <td>
                                <a href="{{ route('artist.albums.show', $album->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('artist.albums.edit', $album->id) }}"
                                    class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('artist.albums.destroy', $album->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this album?');">
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
            {{ $albums->links() }}
        @endif
    </div>
@endsection
