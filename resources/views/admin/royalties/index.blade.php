@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Artist Royalties</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Artist</th>
                    <th>Track Title</th>
                    <th>Genre</th>
                    <th>Actual Play Count</th>
                    <th>Set Play Count</th>
                    <th>Royalty Per Unit</th>
                    <th>Total Royalty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tracks as $track)
                    <tr>
                        <td>{{ $track->artist->user->name }}</td>
                        <td>{{ $track->title }}</td>
                        <td>{{ $track->genre->name ?? 'N/A' }}</td>
                        <td>{{ $track->actual_play_count }}</td>
                        <td>{{ $track->play_count }}</td>
                        <td>${{ number_format($track->royalty_amount, 2) }}</td>
                        <td>${{ number_format($track->total_royalty, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $tracks->links() }}
    </div>
@endsection
