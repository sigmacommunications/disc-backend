
@extends('layout.app')
@section('content')
    <div class="container">
        <h1>Blog</h1>

        <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Create New Blog</a>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Blog Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs  as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->description }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $blog->image) }}"
                            alt="{{ $blog->image }}">
                        </td>

                        <td>
                            <a href="{{ route('blogs.edit', $blog->id) }}"
                                class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete Button (will trigger SweetAlert) -->
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No blog found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


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
