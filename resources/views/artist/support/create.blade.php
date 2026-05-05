@extends('layout.app')

@section('title', 'Create Support Ticket')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Create Support Ticket</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('artist.support.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" name="subject" id="subject"
                        class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                        required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit Ticket</button>
                <a href="{{ route('artist.support.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
