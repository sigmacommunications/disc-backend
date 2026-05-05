@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Track Approvals</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($tracks->isEmpty())
            <p>No tracks pending approval.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Genre</th>
                        <th>Uploaded At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tracks as $track)
                        <tr>
                            <td>{{ $track->title }}</td>
                            <td>{{ $track->artist->user->name }}</td>
                            <td>{{ $track->genre->name }}</td>
                            <td>{{ $track->created_at->format('F d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.track-approvals.show', $track->id) }}" class="btn btn-info btn-sm">View</a>
                                <form action="{{ route('admin.track-approvals.approve', $track->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.track-approvals.reject', $track->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $tracks->links() }}
        @endif
    </div>
@endsection
