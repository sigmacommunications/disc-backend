@extends('layout.app')
@section('title', 'Trending Merch Items')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4 text-info">Trending Merch Items</h2>
        <div class="d-flex justify-content-end mb-3">
            <button id="remove-trending-btn" class="btn btn-danger" disabled>
                Remove Trending
            </button>
        </div>
        <div class="card shadow-lg">
            <div class="card-body">
                <table id="trending-merch-table" class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" id="trending-select-all"></th>
                            <th>Name</th>
                            <th>Artist</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(function() {
            let trendingTable = $('#trending-merch-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.merch.trending-data') }}',
                columns: [{
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: id => `<input type="checkbox" class="trending-checkbox" value="${id}">`
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
                    }
                ]
            });

            // Select all / enable remove button
            $('#trending-select-all').on('click', function() {
                let chk = this.checked;
                $('.trending-checkbox').prop('checked', chk).trigger('change');
            });

            $('#trending-merch-table').on('change', '.trending-checkbox', function() {
                let cnt = $('.trending-checkbox:checked').length;
                $('#remove-trending-btn').prop('disabled', cnt === 0);
                $('#trending-select-all').prop(
                    'checked',
                    cnt === $('.trending-checkbox').length
                );
            });

            // Remove Trending
            $('#remove-trending-btn').on('click', function() {
                let ids = $('.trending-checkbox:checked')
                    .map(function() {
                        return this.value;
                    })
                    .get();
                if (!ids.length || !confirm('Remove selected items from trending?')) return;
                $.post('{{ route('admin.merch.remove-trending') }}', {
                    _token: '{{ csrf_token() }}',
                    ids
                }).done(res => {
                    alert(res.message);
                    trendingTable.ajax.reload();
                    $('#remove-trending-btn').prop('disabled', true);
                }).fail(() => alert('Something went wrong.'));
            });
        });
    </script>
@endsection
