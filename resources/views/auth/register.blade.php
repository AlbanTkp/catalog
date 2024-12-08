@php
    $page_title="Inscription"
@endphp
@extends('layouts.auth')
@section('form-content')
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="row">
      <div class="col-12">
        <div class="input-style-1">
          <label>Name
            @error('name'):&nbsp;
            <span class="text-danger">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
          </label>
          <input id="name" placeholder="Name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        </div>
      </div>

      <div class="col-12">
        <div class="input-style-1">
          <label>Email
            @error('email'):&nbsp;
            <span class="text-danger">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
          </label>
          <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
          <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        </div>
      </div>

      <div class="col-12">
        <div class="input-style-1">
          <label>Password Confirm </label>
          <input id="password-confirm" placeholder="Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
      </div>

      <div class="col-12">
        <div class="form-check checkbox-style mb-30">
          <input class="form-check-input" name="terms" type="checkbox"  id="checkbox-terms"/>
          <label class="form-check-label" for="checkbox-terms">J'accepte les termes et conditions</label >
            @error('terms')
            <br>
            <span class="text-danger">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="button-group d-flex justify-content-center flex-wrap">
          <button class="main-btn primary-btn btn-hover w-100 text-center">
            Sign Up
          </button>
        </div>
      </div>
    </div>
    <!-- end row -->
  </form>
  <div class="singup-option pt-40">
    <p class="text-sm text-medium text-center text-gray">
      Ou Inscrivez-vous avec
    </p>
    <div
      class="button-group pt-40 pb-40 d-flex justify-content-center flex-wrap">
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
      Vous aves déjà un compte? <a href="{{route('login')}}">Connexion</a>
    </p>
  </div>
@endsection
