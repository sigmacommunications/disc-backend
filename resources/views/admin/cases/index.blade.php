@extends('layout.app')

@section('title', 'Case Management')

@section('content')
    <div class="container">
        <h1>Case Management</h1>

        <a href="{{ route('cases.create') }}" class="btn btn-primary mb-3">Create New Case</a>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($cases->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Artist</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cases as $case)
                        <tr>
                            <td>{{ $case->id }}</td>
                            <td>{{ $case->artist->user->name }}</td>
                            <td>{{ $case->title }}</td>
                            <td>
                                <span
                                    class="badge
                                    @if ($case->status == 'open') bg-warning
                                    @elseif($case->status == 'in_progress') bg-info
                                    @elseif($case->status == 'resolved') bg-success @endif">
                                    {{ ucfirst($case->status) }}
                                </span>
                            </td>
                            <td>{{ $case->creator->name }}</td>
                            <td>
                                <a href="{{ route('cases.show', $case->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('cases.edit', $case->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <!-- Delete Button (will trigger SweetAlert) -->
                                <form action="{{ route('cases.destroy', $case->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirmDelete(event)">
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
            {{ $cases->links() }}
        @else
            <p>No cases found.</p>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // SweetAlert confirmation for delete
        function confirmDelete(event) {
            event.preventDefault(); // Prevent form submission

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the case.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Submit the form if confirmed
                }
            });
        }
    </script>
@endsection
