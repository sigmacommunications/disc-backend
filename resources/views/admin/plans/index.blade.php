@extends('layout.app')

@section('content')
<div class="container">
    <h1>Plans</h1>
    <a href="{{ route('plans.create') }}" class="btn btn-primary">Create New Plan</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $plan)
                <tr>
                    <td>{{ $plan->name }}</td>
                    <td>{{ $plan->slug }}</td>
                    <td>{{ $plan->price }}</td>
                    <td>{{ $plan->duration }}</td>
                    <td>
                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
