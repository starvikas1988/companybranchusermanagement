@extends('layouts.app')

@section('content')
    <h2>Add New Branch</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('branches.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="company_id">Company</label>
            <select name="company_id" class="form-control">
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Branch Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
