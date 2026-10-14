@extends('layouts.app')
@section('title', 'Log in')
@section('content')
<section class="auth-page"><div class="auth-aside"><p class="eyebrow">GOOD TO HAVE YOU BACK</p><h1>Pick up<br>where you <em>left off.</em></h1><p>Your work is waiting right where you left it.</p></div><div class="auth-form-wrap"><div class="form-kicker">YOUR ACCOUNT</div><h2>Log in</h2><form class="stack-form" action="{{ route('login') }}" method="post">@csrf
    <label>Email address<input name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>@error('email')<small class="field-error">{{ $message }}</small>@enderror</label>
    <label>Password<input name="password" type="password" autocomplete="current-password" required>@error('password')<small class="field-error">{{ $message }}</small>@enderror</label>
    <label class="check-label"><input name="remember" type="checkbox" value="1"> Keep me logged in</label>
    <button class="button button-dark button-wide" type="submit">Log in <span aria-hidden="true">↗</span></button>
</form><p class="auth-switch">New to Folioform? <a href="{{ route('register') }}">Create an account</a></p></div></section>
@endsection