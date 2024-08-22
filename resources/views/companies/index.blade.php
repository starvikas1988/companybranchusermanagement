@extends('layouts.app')

@section('content')
    <h2>Company List</h2>
    <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3">Add New Company</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>PAN</th>
                <th>GST</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $company->id }}</td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->pan }}</td>
                    <td>{{ $company->gst }}</td>
                    <td>
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
