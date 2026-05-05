<!-- resources/views/admin/contracts/show.blade.php -->

@extends('layouts.admin')

@section('title', 'View Contract')

@section('content')
    <div class="container">
        <h1>Contract Details</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="card mb-3">
            <div class="card-header">
                Contract Information
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $contract->contract_name }}</h5>
                <p class="card-text"><strong>Artist:</strong> {{ $contract->artist->user->name }}
                    ({{ $contract->artist->user->email }})</p>
                <p class="card-text"><strong>Contract Details:</strong></p>
                <p>{{ $contract->contract_details }}</p>
                <p class="card-text"><strong>Start Date:</strong> {{ $contract->start_date->format('F d, Y') }}</p>
                <p class="card-text"><strong>End Date:</strong> {{ $contract->end_date->format('F d, Y') }}</p>
                @if ($contract->file_path)
                    <p class="card-text"><strong>Contract File:</strong>
                        <a href="{{ asset('storage/' . $contract->file_path) }}" target="_blank">View Contract</a>
                    </p>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-warning">Edit Contract</a>
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Back to Contracts</a>
    </div>
@endsection
