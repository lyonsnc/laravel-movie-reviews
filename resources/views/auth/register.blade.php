@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="login-wrapper">
<form class="login-register" method="POST">
    <h1>Create an Account</h1>
    <br>
    <label>
        <span>Username:</span>
        <input type="text" name="username" required>
    </label>

    <label>
        <span>Password:</span>
        <input type="password" name="password" required>
    </label>

    <label>
        <span>Confirm Password:</span>
        <input type="password" name="password_confirmation" required>
    </label>

    <br>
    <div class="login-bottom">
        <button type="submit">Create Account</button>
        <br>
        <br>
        <br>
        <a href="{{ route('login', ['redirect' => request('redirect')]) }}">Already have an account? Log in here</a>
    </div>
</form>
</div>
@endsection