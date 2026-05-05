<!-- resources/views/admin/cases/show.blade.php -->

@extends('layout.app')

@section('title', 'View Case')

@section('content')
    <div class="container">
        <h1>Case Details</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-header">
                Case Information
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $case->id }}</p>
                <p><strong>Artist:</strong> {{ $case->artist->user->name }} ({{ $case->artist->user->email }})</p>
                <p><strong>Title:</strong> {{ $case->title }}</p>
                <p><strong>Description:</strong></p>
                <p>{{ $case->description }}</p>
                <p><strong>Status:</strong>
                    <span
                        class="badge
                        @if ($case->status == 'open') bg-warning
                        @elseif($case->status == 'in_progress') bg-info
                        @elseif($case->status == 'resolved') bg-success @endif">
                        {{ ucfirst($case->status) }}
                    </span>
                </p>
                <p><strong>Created By:</strong> {{ $case->creator->name }} ({{ $case->creator->email }})</p>
                <p><strong>Created At:</strong> {{ $case->created_at->format('F d, Y h:i A') }}</p>
                <p><strong>Updated At:</strong> {{ $case->updated_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>

        @if ($case->artist_response)
            <div class="card mb-3">
                <div class="card-header">
                    Artist Response
                </div>
                <div class="card-body">
                    <p>{{ $case->artist_response }}</p>
                    <p><strong>Responded At:</strong> {{ $case->responded_at->format('F d, Y h:i A') }}</p>
                </div>
            </div>
        @endif

        <a href="{{ route('cases.edit', $case->id) }}" class="btn btn-warning">Edit Case</a>
        <a href="{{ route('cases.index') }}" class="btn btn-secondary">Back to Cases</a>
    </div>
@endsection
