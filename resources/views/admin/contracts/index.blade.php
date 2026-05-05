<!-- resources/views/admin/contracts/index.blade.php -->

@extends('layout.app')

@section('title', 'Contracts Management')

@section('content')
    <div class="container">
        <h1>Contracts</h1>

        <a href="{{ route('contracts.create') }}" class="btn btn-primary mb-3">Create New Contract</a>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Artist</th>
                    <th>Contract Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        <td>{{ $contract->artist->user->name }}</td>
                        <td>{{ $contract->contract_name }}</td>
                        <td>{{ $contract->start_date->format('Y-m-d') }}</td>
                        <td>{{ $contract->end_date->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('contracts.edit', $contract->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete Button (will trigger SweetAlert) -->
                            <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No contracts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $contracts->links() }}
    </div>

    <script>
        // SweetAlert confirmation for delete
        function confirmDelete(event) {
            event.preventDefault(); // Prevent form submission

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Submit the form if confirmed
                }
            });
        }
    </script>
@endsection
