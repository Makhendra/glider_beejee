@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="card-deck">
                <div class="card col-4">
                    <div class="card-body">
                        Если вы не зарегистрированы и не хотите регистрироваться, можете воспользоваться тестовым
                        аккаунтом
                        <br>
                        <br>

                        <b>login</b>: test@test.ru <br>
                        <b>password</b>: test@test.ru <br>
                    </div>
                </div>
                <div class="card col-6">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-2 col-form-label text-md-right">{{ __('messages.email') }}</label>

                                <div class="col-md-10">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-2 col-form-label text-md-right">{{ __('messages.password') }}</label>

                                <div class="col-md-10">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('messages.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-10 offset-md-2">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        {{ __('messages.login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-sm btn-link" href="{{ route('password.request') }}">
                                            {{ __('messages.forgot_your_password') }}?
                                        </a>
                                    @endif

                                    @if (Route::has('register'))
                                        <a class="btn btn-sm btn-link btn-outline-success text-success" href="{{ route('register') }}">
                                            {{ __('messages.register') }}
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
