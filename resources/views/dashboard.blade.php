{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome, {{ auth()->user()->first_name }}!</h2>
    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Welcome to your Dashboard</h2>
    <p>You are logged in successfully!</p>
    {{-- <a href="{{ route('logout') }}">Logout</a> --}}
</div>
@endsection

