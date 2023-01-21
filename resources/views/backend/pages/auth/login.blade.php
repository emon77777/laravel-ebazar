<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="{{ config('app.name', 'Mybazar')}} {{__('Login')}}">
    <meta name="description" content="shop login page">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Mybazar')}} {{__('Login')}}</title>

    <!-- All Device Favicon -->
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
                <h2> @if(config('app.name')){{config('app.name')}} @endif {{__('Login Panel')}}</h2>
                <form name="LoginForm" id="LoginForm" action="{{url('admin/login')}}" method="post">
                    @csrf
                    <div class="input-group">
                        <span><img src="{{URL::to('/backend')}}/img/icons/mail.svg" alt=""></span>
                        <input id="user-email" type="email" placeholder="Email"
                               class="form-control @error('email') ? ' is-invalid' : '' @enderror"
                               name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <label class="error" id="email-error" for="email">{{$message}}</label>
                        @enderror
                    </div>
                    <div class="input-group">
                        <span><img src="{{URL::to('/backend')}}/img/icons/Lock.svg" alt=""></span>
                        <span class="hide-pass" >
                            <img src="{{URL::to('/backend')}}/img/icons/Hide.svg" alt="">
                            <img src="{{URL::to('/backend')}}/img/icons/show.svg" alt="">
                        </span>
                        <input id="password" type="password" placeholder="Password"
                               class="form-control @error('password') ? ' is-invalid' : '' @enderror"
                               name="password" required>
                        @error('password')
                        <label class="error" id="password-error"
                               for="password">{{$message}}</label>
                        @enderror
                    </div>
                    <button type="submit" class="btn login-btn">{{__('Login')}}</button>
                </form>

                <div class="login-footer">
                    <a href="{{ route('backend.password.request') }}">
                        <span><img src="{{URL::to('/backend')}}/img/icons/lock1.svg" alt=""></span>{{__('Forgot Password?')}}</a>
                    <span>
                        <a href="{{url('/')}}"><span><img src="{{URL::to('/backend')}}/img/icons/global.svg" alt=""></span>{{__('Frontend')}}</a>
                    </span>
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
            // validate form on keyup and submit
            $("#LoginForm").validate();

            let showPass = document.querySelector('.hide-pass');
            showPass.addEventListener('click', function() {
                showPass.classList.toggle("show-pass");
                var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            })
        });


    })(jQuery);
    function fillup(email, password)
    {
        document.getElementById("user-email").value = email;
        document.getElementById("password").value = password;
    }
</script>
</body>

</html>


