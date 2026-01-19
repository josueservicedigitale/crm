@extends('auth.auth')

@section('title', 'Verify Email')

@section('content')
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-6 col-xl-5">

            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ url('/') }}">
                        <h3 class="text-primary">
                            <i class="fa fa-hashtag me-2"></i>DASHMIN
                        </h3>
                    </a>
                    <h4>Email Verification</h4>
                </div>

                <p class="text-muted mb-4">
                    Thanks for signing up! Before getting started, please verify your email address
                    by clicking on the link we just emailed to you.
                    If you didn't receive the email, we will gladly send you another.
                </p>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-4">

                    <!-- Resend Verification -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Resend Verification Email
                        </button>
                    </form>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted">
                            Log Out
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection
