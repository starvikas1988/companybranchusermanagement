<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        
        @if (Auth::user()->role ==='admin')
        <h1>Admin Dashboard</h1>
        @elseif (Auth::user()->role ==='user')
        <h1>User Dashboard</h1>
        @endif
        
        <!-- Table for listing users -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Companies</th>
                    <th>Branches</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <ul>
                                @foreach($user->companies as $company)
                                    <li>{{ $company->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <ul>
                                @foreach($user->branches as $branch)
                                    <li>{{ $branch->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
