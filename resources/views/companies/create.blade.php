@extends('layouts.app')

@section('content')
    <h2>Add New Company</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('companies.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="pan">Company PAN</label>
            <input type="text" name="pan" class="form-control" value="{{ old('pan') }}">
        </div>
        <div class="form-group">
            <label for="gst">Company GST</label>
            <input type="text" name="gst" class="form-control" value="{{ old('gst') }}">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
