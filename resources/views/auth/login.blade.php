@extends('auth.auth')

@section('title', 'Sign In')

@section('content')
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height:100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ url('/') }}">
                        <h3 class="text-primary">
                            <i class="fa fa-user-circle me-2"></i> ADMIN
                        </h3>
                    </a>
                    <h3>S'authentifier</h3>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email"
                               name="email"
                               class="form-control"
                               id="email"
                               placeholder="name@example.com"
                               value="{{ old('email') }}"
                               required autofocus>
                        <label for="email"> Address email</label>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password"
                               name="password"
                               class="form-control"
                               id="password"
                               placeholder="Password"
                               required>
                        <label for="password">Mot de passe</label>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">se rappeler de moi</label>
                        </div>

                       @if (\Illuminate\Support\Facades\Route::has('password.request'))

                            <a href="{{ route('password.request') }}">Mot de passe oublié</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">
                        Se connecter
                    </button>

                    <p class="text-center mb-0">
                        Don't have an Account ?
                        <a href="{{ route('register') }}">S'inscrire</a>
                    </p>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
