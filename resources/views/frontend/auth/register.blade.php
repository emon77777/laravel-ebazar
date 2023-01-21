@extends('frontend.layouts.auth')

@section('title','Create New Account')

@section('content')
    <h2>{{ __('Create Your Account') }}</h2>
    <form action="{{ route('customer.register') }}" method="post" >
        @csrf
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/User.svg') }}" alt=""></span>
            <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="First Name">
            @if($errors->has('first_name')) <p>{{ $errors->first('first_name') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/User.svg') }}" alt=""></span>
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Last Name">
            @if($errors->has('last_name')) <p>{{ $errors->first('last_name') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Call.svg') }}" alt=""></span>
            <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="Number">
            @if($errors->has('mobile')) <p>{{ $errors->first('mobile') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/mail.svg') }}" alt=""></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@domain.com">
            @if($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/User.svg') }}" alt=""></span>
            <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Username">
            @if($errors->has('username')) <p>{{ $errors->first('username') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Lock.svg') }}" alt=""></span>
            <span class="hide-pass">
                            <img src="{{ asset('customer/img/icons/Hide.svg') }}" alt="">
                            <img src="{{ asset('customer/img/icons/show.svg') }}" alt="">
                        </span>
            <input type="password" id="myPass" name="password" class="form-control" placeholder="Password">
            @if($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
        </div>
        <div class="input-group">
            <span><img src="{{ asset('customer/img/icons/Lock.svg') }}" alt=""></span>
            <span class="hide-pas">
                            <img src="{{ asset('customer/img/icons/Hide.svg') }}" alt="">
                            <img src="{{ asset('customer/img/icons/show.svg') }}" alt="">
                        </span>
            <input type="password" id="myPas" name="password_confirmation" class="form-control" placeholder="Re-type Password">
        </div>
        <button type="submit" class="btn login-btn">{{ __('Create Account') }}</button>
    </form>
    <div class="login-footer">
        <a href="{{ route('customer.login') }}"><span><img src="{{ asset('customer/img/icons/user.svg') }}" alt=""></span>{{ __('Go to login')}}</a>
        <a href="{{ route('customer.password.email') }}"><span><img src="{{ asset('customer/img/icons/lock1.svg') }}" alt=""></span>{{ __('Forgot Password?') }}</a>
    </div>
@stop

@push('script')
    <script>
        let showPass1 = document.querySelector('.hide-pas');
        showPass1.addEventListener('click', function() {
            showPass1.classList.toggle("show-pass");
            var y = document.getElementById("myPas");
            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }
        })

        let showPass = document.querySelector('.hide-pass');
        showPass.addEventListener('click', function() {
            showPass.classList.toggle("show-pass");
            var x = document.getElementById("myPass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        })
    </script>
@endpush
