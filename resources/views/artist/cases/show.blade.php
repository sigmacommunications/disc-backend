@extends('layout.app')

@section('title', 'Case Details')

@section('content')
    <div class="container">
        <h1>Case Details</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-header">
                <strong>Title:</strong> {{ $case->title }}
            </div>
            <div class="card-body">
                <p><strong>Description:</strong></p>
                <p>{{ $case->description }}</p>

                <p><strong>Status:</strong>
                    <span
                        class="badge
                        @if ($case->status == 'open') bg-warning
                        @elseif($case->status == 'in_progress') bg-info
                        @elseif($case->status == 'resolved') bg-success @endif">
                        {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                    </span>
                </p>

                <p><strong>Created By:</strong> {{ $case->creator->name }} ({{ $case->creator->email }})</p>
                <p><strong>Created At:</strong> {{ $case->created_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>

        @if ($case->artist_response)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Your Response:</strong>
                </div>
                <div class="card-body">
                    <p>{{ $case->artist_response }}</p>
                    <p><strong>Responded At:</strong> {{ $case->responded_at->format('F d, Y h:i A') }}</p>
                </div>
            </div>
        @endif

        @if ($case->status != 'resolved')
            <div class="card">
                <div class="card-header">
                    <strong>
                        Respond to this Case
                    </strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('artist.cases.respond', $case->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="artist_response" class="form-label"> @if ($case->artist_response)
                                Edit
                            @endif Your Response</label>
                            <textarea class="form-control" id="artist_response" name="artist_response" rows="4" required>{{ old('artist_response', $case->artist_response) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Submit Response</button>
                    </form>
                </div>
            </div>
        @endif

        <a href="{{ route('artist.cases.index') }}" class="btn btn-secondary mt-3">Back to My Cases</a>
    </div>
@endsection
