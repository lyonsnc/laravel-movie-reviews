@extends('layouts.app')

@section('title', 'Login')

@section('content')



<div class="login-wrapper">
<form class="login-register" method="POST">
    @csrf
    <h1>Log in</h1>
    <label>
        <span>Username:</span>
        <input type="text" name="username" required>
    </label>

    <label>
        <span>Password:</span>
        <input type="password" name="password" required>
    </label>

    

    <div class="login-bottom">
        <button type="submit">Go!</button>
        <br>
        <br>
        <br>
        <a href="{{ route('register', ['redirect' => request('redirect')]) }}">Register new accounts here!</a>
    </div>
</form>
</div>

@endsection
