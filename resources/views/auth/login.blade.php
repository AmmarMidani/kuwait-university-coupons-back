@extends('layouts.auth')

@section('pagename')
{{ __('website.login') }}
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
            <span class="app-brand-text demo text-heading fw-semibold">{{ __('website.kuwait_university') }}</span>
        </a>
    </div>
    <!-- /Logo -->

    <div class="card-body mt-1 text-center">
        <h4 class="mb-1" dir="rtl">{{ __('website.welcome_to') }} {{ __('website.kuwait_university_food_hub')}}! 👋</h4>
        <p class="mb-5">{{ __('website.please_sign_in_to_your_account') }}</p>

        <form id="formAuthentication" class="mb-5" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-floating form-floating-outline mb-5">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    autocomplete="email" required value="{{ old('email') }}" placeholder="{{ __('website.enter_your_email') }}" autofocus />
                <label for="email">{{ __('website.email') }}</label>
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
                                placeholder="{{ __('website.password') }}" autocomplete="current-password" required
                                aria-describedby="password" />
                            <label for="password">{{ __('website.password') }}</label>
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
                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('website.sign_in') }}</button>
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
