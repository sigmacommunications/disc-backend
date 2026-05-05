@extends('layout.app')
@section('title', 'Merch Items Management')

@section('content')
    <div class="container mt-4">

        <h2 class="text-center mb-4 text-primary">Merch Items Pending Approval</h2>
        <div class="card mb-5 shadow-lg">
            <div class="card-body">
                <table id="pending-merch-table" class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <h2 class="text-center mb-3 text-success">Approved Merch Items</h2>
        <div class="d-flex justify-content-between mb-2">
            <a href="{{ route('admin.merch.trending') }}" class="btn btn-info">Manage Trending Items</a>
            <button id="mark-trending-btn" class="btn btn-primary" disabled>
                Mark as Trending
            </button>
        </div>
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="approved-merch-table" class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" id="approved-select-all"></th>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(function() {
            // Pending table
            $('#pending-merch-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.merch.pending-data') }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'artist',
                        name: 'artist'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Approved table + checkboxes
            let approvedTable = $('#approved-merch-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.merch.approved-data') }}',
                columns: [{
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: (id) =>
                            `<input type="checkbox" class="approved-checkbox" value="${id}">`
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'artist',
                        name: 'artist'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Select all / enable button logic
            $('#approved-select-all').on('click', function() {
                let checked = this.checked;
                $('.approved-checkbox').prop('checked', checked).trigger('change');
            });

            $('#approved-merch-table').on('change', '.approved-checkbox', function() {
                let count = $('.approved-checkbox:checked').length;
                $('#mark-trending-btn').prop('disabled', count === 0);
                $('#approved-select-all').prop(
                    'checked',
                    count === $('.approved-checkbox').length
                );
            });

            // Mark as Trending
            $('#mark-trending-btn').on('click', function() {
                let ids = $('.approved-checkbox:checked')
                    .map(function() {
                        return this.value;
                    })
                    .get();
                if (!ids.length || !confirm('Mark selected items as trending?')) return;
                $.post('{{ route('admin.merch.mark-trending') }}', {
                    _token: '{{ csrf_token() }}',
                    ids
                }).done(res => {
                    alert(res.message);
                    approvedTable.ajax.reload();
                    $('#mark-trending-btn').prop('disabled', true);
                }).fail(() => alert('Something went wrong.'));
            });
        });
    </script>
@endsection
