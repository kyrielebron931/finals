@extends('layouts.app')
@section('title', 'Create an account')
@section('content')
<section class="auth-page"><div class="auth-aside"><p class="eyebrow">YOUR NEXT CHAPTER STARTS HERE</p><h1>Good work<br>deserves a <em>home.</em></h1><p>Make a portfolio you’re proud to send. Your first draft is only a few details away.</p></div><div class="auth-form-wrap"><div class="form-kicker">START YOUR STUDIO</div><h2>Create an account</h2><form class="stack-form" action="{{ route('register') }}" method="post">@csrf
    <label>Your name<input name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus>@error('name')<small class="field-error">{{ $message }}</small>@enderror</label>
    <label>Email address<input name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>@error('email')<small class="field-error">{{ $message }}</small>@enderror</label>
    <label>Password<input name="password" type="password" autocomplete="new-password" minlength="8" required><small>Use at least 8 characters.</small>@error('password')<small class="field-error">{{ $message }}</small>@enderror</label>
    <label>Confirm password<input name="password_confirmation" type="password" autocomplete="new-password" required></label>
    <button class="button button-dark button-wide" type="submit">Create account <span aria-hidden="true">↗</span></button>
</form><p class="auth-switch">Already have an account? <a href="{{ route('login') }}">Log in</a></p></div></section>
@endsection