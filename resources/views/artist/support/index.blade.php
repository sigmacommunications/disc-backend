@extends('layout.app')

@section('title', 'Support Tickets')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Support Tickets</h1>
            <a href="{{ route('artist.support.create') }}" class="btn btn-primary">Create New Ticket</a>
        </div>

        @if ($tickets->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>
                                <a href="{{ route('artist.support.show', $ticket->id) }}">
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
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $tickets->links() }}
        @else
            <p>No support tickets found. <a href="{{ route('artist.support.create') }}">Create one now.</a></p>
        @endif
    </div>
@endsection
