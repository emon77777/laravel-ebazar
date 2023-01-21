@extends('backend.layouts.app')
@section('title','Seller Show - ')
@section('content')
    <div class="content-body">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="create-seller" role="tabpanel"
                 aria-labelledby="create-seller-tab">
                <div class="container content-title">
                    <h4>{{__('Seller Information')}}</h4>
                </div>
                <div class="container">
                    <div class="row">
                        <form class="add-brand-form">
                            <div class="row">
                                <div class="col-lg-2">
                                    <p>{{__('First Name')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->first_name}}
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Last Name')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->last_name}}
                                </div>
                                <input type="hidden" name="user_type" value="1">
                                <div class="col-lg-2">
                                    <p>{{__('Email')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->email}}
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Mobile Number')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->mobile}}
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Gender')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->user_gender==0)
                                        Other
                                    @elseif($seller->user_gender==1)
                                        Male
                                    @else
                                        Female
                                    @endif
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Username')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->username}}
                                </div>

                                <div class="col-lg-2">
                                    <p>{{__('Address')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->address}}
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Address 2')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->profile->address_2??''}}
                                </div>

                                <div class="col-lg-2">
                                    <p>{{__('Post Code')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->profile->post_code??''}}
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('City')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->profile->city??''}}
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Domain Name')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    {{$seller->profile->domain_name??''}}
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Domain SSL')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-switch">
                                        <input name="domain_ssl_stat" class="form-check-input"
                                               @if($seller->profile && $seller->profile->domain_ssl_stat)checked @endif type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="container content-title">
                                <h4>{{__('Seller Business Information')}}</h4>
                            </div>
                            <div class="clearfix mt-3"></div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <p>{{__('Company Name')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->profile && $seller->profile->company_name){{$seller->profile->company_name}}@endif
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Business Email')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->profile && $seller->profile->email){{$seller->profile->email}}@endif
                                </div>

                                <div class="col-lg-2">
                                    <p>{{__('Business Mobile Number')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->profile && $seller->profile->mobile){{$seller->profile->mobile}}@endif
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('NID')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->profile && $seller->profile->nid_no){{$seller->profile->nid_no}}@endif
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Passport')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->profile && $seller->profile->passport_no){{$seller->profile->passport_no}}@endif
                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Business Address')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->profile && $seller->profile->address){{$seller->profile->address}}@endif
                                </div>
                            </div>
                            <div class="container content-title">
                                <h4>{{__('Seller Commission')}}</h4>
                            </div>
                            <div class="clearfix mt-3"></div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <p>{{__('Commission')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->commission && $seller->commission->seller_commission){{$seller->commission->seller_commission}}
                                    %@endif

                                </div>
                                <div class="col-lg-2">
                                    <p>{{__('Note')}}</p>
                                </div>
                                <div class="col-lg-4">
                                    @if($seller->commission && $seller->commission->remarks){{$seller->commission->remarks}}@endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>

@endsection
