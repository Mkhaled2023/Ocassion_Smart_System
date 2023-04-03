@extends('layouts.app')

@section('content')
<div class="form-container sign-in-container">
    <form method="POST" action="{{ route('register') }}">
                            @csrf
        <h2>Create Account</h2>
        <input type="text"  class=" @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="UserName" required autocomplete="name" >
        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
        <input type="email"class=" @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">

        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
        <input type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="****" required autocomplete="new-password">

        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input id="password-confirm" type="password" class="form-control" placeholder="****" name="password_confirmation" required autocomplete="new-password">

        <button type="submit">SignUp</button>
    </form>
    </div>
<div class="form-container sign-up-container">

<form method="POST" action="{{ route('login') }}">
                        @csrf

		<h2>Sign In</h2>
        <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">

<!-- @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror -->


    <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="current-password">

<!-- @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror -->

@if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif

	<button type='submit'>Sign In</button>
	</form>
</div>



@endsection
