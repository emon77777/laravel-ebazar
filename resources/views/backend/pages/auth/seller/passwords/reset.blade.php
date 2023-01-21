<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ config('app.name', 'Mybazar')}} {{__('Reset Password')}}">
    <meta name="description" content="{{ config('app.name', 'Mybazar')}} {{__('Reset Password')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Mybazar')}} {{__('Reset Password')}}</title>

    <link rel="icon" href="@if(config('app.favicon')){{asset(config('app.favicon'))}}@endif">

    @include('backend.includes.layout_css')
</head>

<body>

<div class="mybazar-login-section">
    <div class="mybazar-login-wrapper">
        <div class="login-wrapper">
            <div class="login-header">
                <img src="@if(config('app.logo')){{asset(config('app.logo'))}}@endif" alt="logo">
            </div>
            <div class="login-body">
                <h2 class="m-0">{{__('Reset Password')}}</h2>
                <p>{{__('Please Set your New Password')}}</p>
                <form method="POST" action="{{ route('seller.password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="input-group">
                        <span><img src="{{URL::to('/backend/')}}/img/icons/Lock.svg" alt=""></span>
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" required placeholder="New Password ">
                        @error('password')
                        <label id="password-error" class="error "
                               for="password">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="input-group">
                        <span><img src="{{URL::to('/backend/')}}/img/icons/Lock.svg" alt=""></span>
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required placeholder="Confirm Password ">
                    </div>
                    <button type="submit" class="btn login-btn">{{__('Save Password')}}</button>
                </form>
                <div class="login-footer">
                    <span><span><img src="{{URL::to('/backend/')}}/img/icons/lock1.svg" alt=""> {{__('Remember the Password?')}}</span>
                        <a href="{{url('/seller')}}"> {{__('Login')}}</a>
                    </span>
                    <a href="{{url('/')}}"><span><img src="{{URL::to('/backend/')}}/img/icons/global.svg" alt=""></span>{{__('Front-End')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.includes.layout_js')
<script>
    (function ($) {
        "use strict";
        $(document).ready(function () {


        });
    })(jQuery);

</script>
</body>

</html>

