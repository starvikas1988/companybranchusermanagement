@extends('layouts.app')

@section('content')
    <h2>Edit Branch</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('branches.update', $branch->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="company_id">Company</label>
            <select name="company_id" class="form-control">
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ $company->id == $branch->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Branch Name</label>
            <input type="text" name="name" class="form-control" value="{{ $branch->name }}">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $branch->location }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
