@extends('auth.auth')

@section('title', 'Forgot Password')

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
                    <h3>Forgot</h3>
                </div>

                <p class="text-muted mb-4">
                    Forgot your password? No problem. Enter your email address and
                    we will send you a reset link.
                </p>

                <!-- Success message -->
                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-floating mb-4">
                        <input type="email"
                               name="email"
                               class="form-control"
                               id="email"
                               placeholder="name@example.com"
                               value="{{ old('email') }}"
                               required autofocus>
                        <label for="email">Email address</label>

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">
                        Email Password Reset Link
                    </button>

                    <p class="text-center mb-0">
                        <a href="{{ route('login') }}">Back to Sign In</a>
                    </p>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
