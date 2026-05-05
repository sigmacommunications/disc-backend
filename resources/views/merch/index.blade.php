@extends('layout.app')

@section('content')
    <div class="container">
        <h2>Your Merch Items</h2>
        <a href="{{ route('admin.sync.printify') }}" class="btn btn-primary mb-3">Sync Printify</a>
        <a href="{{ route('admin.merch.create') }}" class="btn btn-secondary mb-3">Add New Merch Item</a>
        <table class="table" id="example1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($merchItems as $merchItem)
                    <tr>
                        <td>{{ Str::limit($merchItem->name, 50, '…') }}</td>
                        <td>{{ Str::limit($merchItem->description, 100, '…') }}</td>

                        <td>${{ $merchItem->price }}</td>
                        <td>{{ $merchItem->approved ? 'Approved' : 'Pending' }}</td>
                        <td class="d-flex">
                            <a href="{{ route('admin.merch.edit', $merchItem) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.merch.destroy', $merchItem) }}" method="POST" class=""
                                id="reject-form-{{ $merchItem->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger mx-2 btn-sm"
                                    onclick="confirmReject({{ $merchItem->id }})">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No merch items available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
        function confirmReject(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will delete the item.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reject-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
