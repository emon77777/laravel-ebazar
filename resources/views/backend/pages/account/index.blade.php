@extends('backend.layouts.app')

@section('title','Account User - ')

@section('content')
    <div class="maan-main-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="my-bazar-profile">
                    <div class="card profile-card">
                        <div class="profile-thumb">
                            @if(auth('admin')->user())
                                <img id="profile_picture" width="100px" height="100px"
                                     src="{{URL::to('uploads/users/'.Auth::user()->avatar)}}" alt="user avatar"/>
                            @else
                                <img id="profile_picture" width="100px" height="100px"
                                     src="{{URL::to('uploads/sellers/'.Auth::user()->image)}}" alt="user avatar"/>
                            @endif
                            <h4>{{auth()->user()->name??auth()->user()->full_name()}}</h4>
                        </div>
                        <div class="profile-footer card-body">
                            <div class="profile-footer-items">
                                <h4>{{auth()->user()->getRoleNames()->first()}}</h4>
                                <small>{{ __('Role') }}</small>
                            </div>
                            <div class="profile-footer-items">
                                <h4>{{auth()->user()->email}}</h4>
                                <small>{{ __('Email Address') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card user-nav-card">
                    <div class="nav user-profile-nav mt-0">
                        <a class="active" href="#Profile" data-bs-toggle="pill">{{__('Profile')}}</a>
                        <a href="#EditProfile" data-bs-toggle="pill">{{__('Edit Profile')}}</a>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="Profile">
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>{{__('Name')}}:</strong>
                                        <span> {{auth()->user()->name??auth()->user()->full_name()}} </span></li>
                                    <li class="list-group-item"><strong>{{__('Email')}}:</strong>
                                        <span> {{auth()->user()->email}} </span></li>
                                    <li class="list-group-item"><strong>{{__('Role')}}:</strong>
                                        <span> {{auth()->user()->getRoleNames()->first()}} </span></li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="EditProfile">
                                <div class="user-profile-edit-form">
                                    <form action="@auth('admin'){{route('backend.account.update',auth()->user()->id)}}@elseauth('seller') {{route('seller.account.update',auth()->user()->id)}}@endauth" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        @if(auth('admin')->user())
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label form-control-label">{{ __('Name') }}</label>
                                                <div class="col-lg-8">
                                                    <input name="name"
                                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                           type="text"
                                                           value="@if($user->name){{$user->name}}@else{{ old('name') }}@endif"
                                                           required>
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label form-control-label">{{ __('Fisrt Name') }}</label>
                                                <div class="col-lg-8">
                                                    <input name="first_name"
                                                           class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                                           type="text"
                                                           value="@if($user->first_name){{$user->first_name}}@else{{ old('first_name') }}@endif"
                                                           required>
                                                    @if ($errors->has('first_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('first_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label form-control-label">{{ __('Last Name') }}</label>
                                                <div class="col-lg-8">
                                                    <input name="last_name"
                                                           class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                                           type="text"
                                                           value="@if($user->last_name){{$user->last_name}}@else{{ old('last_name') }}@endif"
                                                           required>
                                                    @if ($errors->has('last_name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('last_name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label form-control-label">{{ __('Email') }}</label>
                                            <div class="col-lg-8">
                                                <input name="email"
                                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                       type="email"
                                                       value="@if($user->email){{$user->email}}@else{{ old('email') }}@endif"
                                                       required>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(auth('admin')->user())
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label form-control-label">{{ __('Profile Picture') }}</label>
                                                <div class="col-lg-8">
                                                    <input name="avatar"
                                                           class="form-control {{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                                                           accept="image/*" type="file"
                                                           onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])">
                                                    @if ($errors->has('avatar'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('avatar') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label form-control-label">{{ __('Profile Picture') }}</label>
                                                <div class="col-lg-8">
                                                    <input name="image"
                                                           class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                           accept="image/*" type="file"
                                                           onchange="document.getElementById('profile_picture').src = window.URL.createObjectURL(this.files[0])">
                                                    @if ($errors->has('image'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('image') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                        @endif

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label form-control-label">{{ __('Current Password') }}</label>
                                            <div class="col-lg-8">
                                                <input id="current_password" type="password"
                                                       class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}"
                                                       name="current_password" >

                                                @if ($errors->has('current_password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('current_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label form-control-label">{{__('Password')}}</label>
                                            <div class="col-lg-8">
                                                <input id="password" type="password"
                                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                       name="password" >

                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label form-control-label">{{__('Confirm password')}}</label>
                                            <div class="col-lg-8">
                                                <input id="password-confirm" type="password" class="form-control"
                                                       name="password_confirmation" >
                                            </div>
                                        </div>
                                        <div class="form-grou">
                                            <input  class="btn user-profile-edit-btn " type="submit" value="Save Changes">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            "use strict";

            $(document).on('click', '.nav .nav-link', function () {
                $(this).parent('li').addClass('active');
                $(this).parent('li').siblings('li').removeClass('active');
            })

        });
    </script>
@endpush
