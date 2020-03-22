@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3 class="text-center">Welcome to Clear Applicant Tracking</h3>
        <div class="col-md-6">
            <div class="card" style="background-color: #6B6570; color: #EFF6E0">
                <div class="card-header text-center"><h5 class="m-0">{{ __('Login') }}</h5></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row">
                            <div class="input-field col s6">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                              <input id="email" type="email" class=" validate autocomplete @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                              
                              @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>
                        </div>
                          

                        <div class=" row">
                            <div class="input-field col s6">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="validate autocomplete @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-check mx-auto">
                                <label class="form-check-label" for="remember">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span> {{ __('Remember Me') }}</span>
                                </label>
                            </div>
                           
                        </div>

                        <div class="row">
                            <div class="mx-auto">
                                <button type="submit" class="btn waves-effect waves-light">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mx-auto">
                                @if (Route::has('password.request'))
                                    <a style="color: #EFF6E0" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
