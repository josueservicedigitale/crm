@extends('auth.auth')

@section('title', 'Confirm Password')

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
                    <h3>Confirm</h3>
                </div>

                <p class="text-muted mb-4">
                    This is a secure area of the application.
                    Please confirm your password before continuing.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div class="form-floating mb-4">
                        <input type="password"
                               name="password"
                               class="form-control"
                               id="password"
                               placeholder="Password"
                               required
                               autocomplete="current-password">
                        <label for="password">Password</label>

                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100">
                        Confirm Password
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
@endsection
