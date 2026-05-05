@extends('layout.app')

@section('title', 'My Cases')

@section('content')
    <div class="container">
        <h1>My Cases</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($cases->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cases as $case)
                        <tr>
                            <td>{{ $case->id }}</td>
                            <td>{{ $case->title }}</td>
                            <td>
                                <span
                                    class="badge
                                    @if ($case->status == 'open') bg-warning
                                    @elseif($case->status == 'in_progress') bg-info
                                    @elseif($case->status == 'resolved') bg-success @endif">
                                    {{ ucfirst(str_replace('_', ' ', $case->status)) }}
                                </span>
                            </td>
                            <td>{{ $case->creator->name }} ({{ $case->creator->email }})</td>
                            <td>{{ $case->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('artist.cases.show', $case->id) }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            {{ $cases->links() }}
        @else
            <p>You have no cases.</p>
        @endif
    </div>
@endsection
