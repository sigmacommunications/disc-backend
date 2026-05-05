<!-- resources/views/admin/contracts/edit.blade.php -->

@extends('layout.app')

@section('title', 'Edit Contract')

@section('content')
    <div class="container">
        <h1>Edit Contract</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Artist Selection -->
            <div class="mb-3">
                <label for="artist_id" class="form-label">Artist</label>
                <select class="form-select" id="artist_id" name="artist_id" required>
                    <option value="">Select Artist</option>
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}"
                            {{ old('artist_id', $contract->artist_id) == $artist->id ? 'selected' : '' }}>
                            {{ $artist->user->name }} ({{ $artist->user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Contract Name -->
            <div class="mb-3">
                <label for="contract_name" class="form-label">Contract Name</label>
                <input type="text" class="form-control" id="contract_name" name="contract_name"
                    value="{{ old('contract_name', $contract->contract_name) }}" required>
            </div>

            <!-- Contract Details -->
            <div class="mb-3">
                <label for="contract_details" class="form-label">Contract Details</label>
                <textarea class="form-control" id="contract_details" name="contract_details" rows="5">{{ old('contract_details', $contract->contract_details) }}</textarea>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date"
                    value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}" required>
            </div>

            <!-- End Date -->
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date"
                    value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}" required>
            </div>

            <!-- Current Contract File -->
            @if ($contract->file_path)
                <div class="mb-3">
                    <label class="form-label">Current Contract File:</label>
                    <p>
                        <a href="{{ asset('storage/' . $contract->file_path) }}" target="_blank">View Contract</a>
                    </p>
                </div>
            @endif

            <!-- Upload New Contract File -->
            <div class="mb-3">
                <label for="contract_file" class="form-label">Upload New Contract File</label>
                <input type="file" class="form-control" id="contract_file" name="contract_file"
                    accept=".pdf,.docx,.jpeg,.jpg,.png">
                <small class="form-text text-muted">Allowed file types: pdf, docx, jpeg, jpg, png. Max size: 2MB.</small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Contract</button>
            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
