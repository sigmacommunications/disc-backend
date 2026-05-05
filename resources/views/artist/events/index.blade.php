@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Your Events</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to Create New Event -->
        <a href="{{ route('artist.events.create') }}" class="btn btn-primary mb-3">Add New Event</a>

        @if ($events->isEmpty())
            <p>You have not added any events yet.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Event Date & Time</th>
                        <th>Ticket Link</th>
                        <th>Promotional Details</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->event_date->format('F d, Y h:i A') }}</td>
                            <td>
                                @if ($event->ticket_link)
                                    <a href="{{ $event->ticket_link }}" target="_blank">Buy Tickets</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ Str::limit($event->promotional_details, 50) }}</td>
                            <td>
                                <a href="{{ route('artist.events.show', $event->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('artist.events.edit', $event->id) }}"
                                    class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('artist.events.destroy', $event->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this event?');">
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
            {{ $events->links() }}
        @endif
    </div>
@endsection
