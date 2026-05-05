<!-- resources/views/admin/contracts/create.blade.php -->

@extends('layout.app')

@section('title', 'Create New Contract')

@section('content')
    <div class="container">
        <h1>Create New Contract</h1>

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

        <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Artist Selection -->
            <div class="mb-3">
                <label for="artist_id" class="form-label">Artist</label>
                <select class="form-select" id="artist_id" name="artist_id" required>
                    <option value="">Select Artist</option>
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ $artist->user->name }} ({{ $artist->user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Contract Name -->
            <div class="mb-3">
                <label for="contract_name" class="form-label">Contract Name</label>
                <input type="text" class="form-control" id="contract_name" name="contract_name"
                    value="{{ old('contract_name') }}" required>
            </div>

            <!-- Contract Details -->
            <div class="mb-3">
                <label for="contract_details" class="form-label">Contract Details</label>
                <textarea class="form-control" id="contract_details" name="contract_details">{{ old('contract_details') }}</textarea>
            </div>

            <!-- Start Date -->
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}"
                    required>
            </div>

            <!-- End Date -->
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}"
                    required>
            </div>

            <!-- Contract File Upload -->
            <div class="mb-3">
                <label for="contract_file" class="form-label">Upload Contract File</label>
                <input type="file" class="form-control" id="contract_file" name="contract_file"
                    accept=".pdf,.docx,.jpg,.jpeg,.png">
            </div>

            <button type="submit" class="btn btn-primary">Save Contract</button>
        </form>
    </div>
@endsection
