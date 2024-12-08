@php
    $page_title="Connexion"
@endphp
@extends('layouts.auth')
@section('form-content')
<form method="POST" action="{{ route('login') }}">
  @csrf
  <div class="row">
    <div class="col-12">
      <div class="input-style-1">
        <label>Email
        @error('email'):&nbsp;
        <span class="text-danger">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        </label>
        <input name="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus/>
      </div>
    </div>

    <div class="col-12">
      <div class="input-style-1">
        <label>Password
          @error('password'):&nbsp;
          <span class="text-danger">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
        </label>
        <input name="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
      </div>
    </div>

    <div class="col-xxl-6 col-lg-12 col-md-6">
      <div class="form-check checkbox-style mb-30">
        <input class="form-check-input" type="checkbox" name="remember" id="checkbox-remember" {{ old('remember') ? 'checked' : '' }}/>
        <label class="form-check-label" for="checkbox-remember">
          Remember me next time
        </label>
      </div>
    </div>

    @if (Route::has('password.request'))
    <div class="col-xxl-6 col-lg-12 col-md-6">
      <div class="text-start text-md-end text-lg-start text-xxl-end mb-30">
        <a href="{{ route('password.request') }}" class="hover-underline">Forgot Password?</a>
      </div>
    </div>
    @endif

    <div class="col-12">
      <div class="button-group d-flex justify-content-center flex-wrap">
        <button class="main-btn primary-btn btn-hover w-100 text-center">
          Sign In
        </button>
      </div>
    </div>
  </div>

</form>
<div class="singin-option pt-40">
  <p class="text-sm text-medium text-center text-gray">
    Ou Connectez-vous avec
  </p>
  <div class="button-group pt-40 pb-40 d-flex justify-content-center flex-wrap">
    <button class="main-btn primary-btn-outline m-2">
      <i class="lni lni-facebook-fill mr-10"></i>
      Facebook
    </button>
    <button class="main-btn danger-btn-outline m-2">
      <i class="lni lni-google mr-10"></i>
      Google
    </button>
  </div>
  <p class="text-sm text-medium text-dark text-center">
    Pas encore de compte?
    <a href="{{route('register')}}">Créer un compte</a>
  </p>
</div>
@endsection
