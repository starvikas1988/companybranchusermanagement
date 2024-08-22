@extends('layouts.app')

@section('content')
    <h2>Edit Company</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" name="name" class="form-control" value="{{ $company->name }}">
        </div>
        <div class="form-group">
            <label for="pan">Company PAN</label>
            <input type="text" name="pan" class="form-control" value="{{ $company->pan }}">
        </div>
        <div class="form-group">
            <label for="gst">Company GST</label>
            <input type="text" name="gst" class="form-control" value="{{ $company->gst }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
