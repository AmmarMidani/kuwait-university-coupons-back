@extends('layouts.auth')

@section('pagename')
Login
@endsection

@section('css')
@endsection

@section('content')
<!-- Login -->
<div class="card p-md-7 p-1">
    <!-- Logo -->
    <div class="app-brand justify-content-center mt-5">
        <a href="{{route('welcome')}}" class="app-brand-link gap-2">
            <img src="{{ asset('assets/img/favicon/favicon.ico') }}?v={{ config('app.version') }}" alt="">
            <span class="app-brand-text demo text-heading fw-semibold">Kuwait University</span>
        </a>
    </div>
    <!-- /Logo -->

    <div class="card-body mt-1">
        <h4 class="mb-1">Welcome to {{ config('app.name', 'Laravel') }}! 👋</h4>
        <p class="mb-5">Please sign-in to your account</p>

        <form id="formAuthentication" class="mb-5" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    autocomplete="email" required value="{{ old('email') }}" placeholder="Enter your email" autofocus />
                <label for="email">Email</label>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-5">
                <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                        <div class="form-floating form-floating-outline">
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Password" autocomplete="current-password" required
                                aria-describedby="password" />
                            <label for="password">Password</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
        </form>
    </div>
</div>
<!-- /Login -->
<img alt="mask"
    src="{{ asset('assets/img/illustrations/auth-basic-login-mask-light.png') }}?v={{ config('app.version') }}"
    class="authentication-image d-none d-lg-block" />
@endsection

@section('js')
@endsection
