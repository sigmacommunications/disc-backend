@extends('layout.app')

@section('title', 'Transparency Reports')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Transparency Reports</h1>
            <a href="{{ route('artist.reports.download') }}" class="btn btn-primary">Download PDF</a>
        </div>

        <h3>Total Earnings: ${{ number_format($totalEarnings, 2) }}</h3>

        @if ($royalties->count())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date Earned</th>
                        <th>Amount</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($royalties as $royalty)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($royalty->earned_at)->format('Y-m-d') }}</td>
                            <td>${{ number_format($royalty->amount, 2) }}</td>
                            <td>{{ $royalty->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No royalty records found.</p>
        @endif
    </div>
@endsection
