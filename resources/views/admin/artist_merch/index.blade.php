@extends('layout.app')
@section('title', 'Merch Items Pending Approval')
@section('content')

    <style>
        table {
            font-size: 1rem;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
        }

        .card {
            background-color: #f8f9fa;
        }

        .table td {
            font-weight: 500;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn {
            width: 100%;
            text-align: center;
        }

        .btn-sm {
            width: auto;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .container {
            max-width: 1000px;
        }
    </style>
    <div class="container mt-4">
        <h2 class="text-center mb-4 text-primary">Artist Merch Items Pending Approval</h2>

        <div class="card shadow-lg">
            <div class="card-body">
                @forelse ($merchItems as $merchItem)
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th><br>
                                <th>Artist</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $merchItem->name }}</td>
                                <td>{{ $merchItem->user->name }}</td>
                                <td>${{ $merchItem->price }}</td>
                                <td class="d-flex">
                                    <form action="{{ route('artist-merch.reject', $merchItem) }}" method="POST" class="mr-2"
                                        id="reject-form-{{ $merchItem->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmReject({{ $merchItem->id }})">Reject & Delete</button>
                                    </form>
                                    <form action="{{ route('artist-merch.approve', $merchItem) }}" method="POST"
                                        class="mr-2" id="approve-form-{{ $merchItem->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-success mx-2 btn-sm"
                                            onclick="confirmApprove({{ $merchItem->id }})">Approve</button>
                                    </form>
                                    <a href="{{ route('artist-merch.edit', $merchItem) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @empty
                    <p class="text-center text-muted">No merch items pending approval at the moment.</p>

                    {{-- Approved Items Table --}}
                    @forelse ($approvedItems as $merchItem)
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th><br>
                                    <th>Artist</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $merchItem->name }}</td>
                                    <td>{{ $merchItem->user->name }}</td>
                                    <td>${{ $merchItem->price }}</td>
                                    <td>
                                        <a href="{{ route('artist-merch.edit', $merchItem) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @empty
                        <p class="text-muted text-center">No approved items found.</p>
                    @endforelse
                @endforelse
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        function confirmReject(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will reject and delete the item.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reject-form-' + id).submit();
                }
            });
        }

        function confirmApprove(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will approve the merch item.",
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
