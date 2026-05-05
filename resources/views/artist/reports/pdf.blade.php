<!DOCTYPE html>
<html>

<head>
    <title>Transparency Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .header h3 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Transparency Report</h1>
        <h3>Artist: {{ $artist->user->name }}</h3>
        <h3>Total Earnings: ${{ number_format($totalEarnings, 2) }}</h3>
    </div>

    <table>
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
</body>

</html>
