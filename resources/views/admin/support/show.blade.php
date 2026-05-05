@extends('layout.app')

@section('title', 'View Support Ticket')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h2>{{ $ticket->subject }}</h2>
            <span class="badge bg-{{ $ticket->status === 'open' ? 'success' : 'secondary' }}">
                {{ ucfirst($ticket->status) }}
            </span>
        </div>
        <div class="card-body">
            <p><strong>Artist:</strong> {{ $ticket->artist->user->name }}</p>
            <p><strong>Created At:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
            <p>{{ $ticket->message }}</p>
        </div>
    </div>

    <div class="mb-3">
        <h4>Responses</h4>
        @if ($ticket->responses->count())
            @foreach ($ticket->responses as $response)
                <div class="card mb-2">
                    <div class="card-header">
                        <strong>{{ $response->user->name }}</strong>
                        <span class="text-muted">- {{ $response->created_at->format('Y-m-d H:i') }}</span>
                        @if (!$response->is_read && $response->user_id != Auth::id())
                            <span class="badge bg-warning">New</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <p>{{ $response->message }}</p>
                    </div>
                </div>
            @endforeach
        @else
            <p>No responses yet.</p>
        @endif
    </div>

    @if ($ticket->status === 'open')
        <form action="{{ route('support.respond', $ticket->id) }}" method="POST" class="mb-3">
            @csrf
            <div class="mb-3">
                <label for="message" class="form-label">Add a Response</label>
                <textarea name="message" id="message" rows="3" class="form-control @error('message') is-invalid @enderror"
                    required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Add Response</button>
        </form>
    @endif

    @if ($ticket->status === 'open')
        <form action="{{ route('support.close', $ticket->id) }}" id="close-ticket-form" method="POST">
            @csrf
            <button type="submit" id="close-ticket-button" class="btn btn-danger">Close Ticket</button>
        </form>
    @endif

    <a href="{{ route('support.index') }}" class="btn btn-secondary mt-3">Back to Support Tickets</a>
@endsection
@section('scripts')

    @if ($ticket->status === 'open')
        <script>
            document.getElementById('close-ticket-button').addEventListener('click', function(e) {
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to close this ticket.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, close it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('close-ticket-form').submit();
                    }
                })
            });
        </script>
    @endif
@endsection
