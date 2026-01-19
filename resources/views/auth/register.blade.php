@extends('auth.auth')

@section('title', 'Sign Up')

@section('content')
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">

            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ url('/') }}">
                        <h3 class="text-primary">
                            <i class="fa fa-hashtag me-2"></i>DASHMIN
                        </h3>
                    </a>
                    <h3>Sign Up</h3>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-floating mb-3">
                        <input type="text"
                               name="name"
                               class="form-control"
                               id="name"
                               placeholder="Username"
                               value="{{ old('name') }}"
                               required>
                        <label for="name">Username</label>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input type="email"
                               name="email"
                               class="form-control"
                               id="email"
                               placeholder="name@example.com"
                               value="{{ old('email') }}"
                               required>
                        <label for="email">Email address</label>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3">
                        <input type="password"
                               name="password"
                               class="form-control"
                               id="password"
                               placeholder="Password"
                               required>
                        <label for="password">Password</label>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-floating mb-4">
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               id="password_confirmation"
                               placeholder="Confirm Password"
                               required>
                        <label for="password_confirmation">Confirm Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">
                        Sign Up
                    </button>

                    <p class="text-center mb-0">
                        Already have an Account ?
                        <a href="{{ route('login') }}">Sign In</a>
                    </p>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
