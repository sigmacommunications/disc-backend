@extends('layout.app')

@section('content')
    <div class="container">

        <h1>Artists</h1>


        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="">

            <a href="{{ route('artists.create') }}" class="btn btn-primary mb-3">Create New Artist</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Bio</th>
                    <th>Social Links</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($artists as $artist)
                    <tr>
                        <td>{{ $artist->user->name }}</td>
                        <td>{{ $artist->user->email }}</td>
                        <td>{{ $artist->bio }}</td>
                        <td>
                            @if ($artist->twitter)
                                <a href="{{ $artist->twitter }}" target="_blank">Twitter</a><br>
                            @endif
                            @if ($artist->instagram)
                                <a href="{{ $artist->instagram }}" target="_blank">Instagram</a><br>
                            @endif
                            @if ($artist->facebook)
                                <a href="{{ $artist->facebook }}" target="_blank">Facebook</a><br>
                            @endif
                        </td>
                        <td>
                            @if ($artist->user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Suspended</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('artists.edit', $artist) }}" class="btn btn-primary btn-sm">Edit</a>
                            {{-- <a href="{{ route('contracts.index', $artist) }}" class="btn btn-info btn-sm">Contracts</a> --}}
                            <!-- Toggle active status -->
                            <form action="{{ route('artists.toggle', $artist->user_id) }}" method="POST" class="d-inline"
                                id="toggleForm_{{ $artist->id }}">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-warning btn-sm">
                                    {{ $artist->user->is_active ? 'Suspend' : 'Activate' }}
                                </button>
                            </form>
                            <!-- Delete Artist -->
                            <form action="{{ route('artists.destroy', $artist) }}" method="POST" class="d-inline"
                                id="deleteForm_{{ $artist->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </table>

        {{ $artists->links() }}
    </div>
@endsection
@section('scripts')
   

    <script>
        // Confirmation for activating/suspending an artist account
        @foreach ($artists as $artist)
            document.getElementById('toggleForm_{{ $artist->id }}').onsubmit = function(e) {
                e.preventDefault(); // Prevent form submission
                const action = '{{ $artist->user->is_active ? 'suspend' : 'activate' }}';
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to ' + action + ' this artist account?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, ' + action,
                    cancelButtonText: 'No, cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Proceed with the form submission
                    }
                });
            };
        @endforeach

        // Confirmation for deleting an artist
        @foreach ($artists as $artist)
            document.getElementById('deleteForm_{{ $artist->id }}').onsubmit = function(e) {
                e.preventDefault(); // Prevent form submission
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to delete this artist?',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Proceed with the form submission
                    }
                });
            };
        @endforeach
    </script>
@endsection
