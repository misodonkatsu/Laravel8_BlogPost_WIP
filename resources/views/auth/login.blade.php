@extends('layouts.app')
@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>E-mail</label>
            <input name="email" value="{{ old('email', 'testMail@gmail.com') }}" required
                class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}">

            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label>Password</label>
            <input name="password" required type="password" value="{{ old('password', 'password') }}"
                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">

            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input name="remember" type="checkbox" value="{{ old('remember') ? 'checked' : '' }}"
                class="form-check-input">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login!</button>
    </form>    
@endsection