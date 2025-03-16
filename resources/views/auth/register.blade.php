@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <h1>Register</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="first_name">First Name</label>
        <input type="text" name="first_name" required>

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Register</button>
    </form>
@endsection

