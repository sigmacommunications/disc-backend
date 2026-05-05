@extends('layout.app')

@section('title', 'Manage Support Tickets')

@section('content')
    <div class="container">

        <h1>Manage Support Tickets</h1>

        @if ($tickets->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Artist</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->artist->user->name }}</td>
                            <td>
                                <a href="{{ route('support.show', $ticket->id) }}">
                                    {{ $ticket->subject }}
                                </a>
                            </td>
                            <td>
                                @if ($ticket->status === 'open')
                                    <span class="badge bg-success">Open</span>
                                @else
                                    <span class="badge bg-secondary">Closed</span>
                                @endif
                            </td>
                            <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $ticket->updated_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('support.show', $ticket->id) }}"
                                    class="btn btn-sm btn-primary">View</a>
                                @if ($ticket->status === 'open')
                                    <form action="{{ route('support.close', $ticket->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Close</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $tickets->links() }}
        @else
            <p>No support tickets found.</p>
        @endif
    </div>
@endsection
