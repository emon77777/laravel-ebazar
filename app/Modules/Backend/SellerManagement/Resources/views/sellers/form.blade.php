<div class="row">
    <form class="add-brand-form">
        <div class="row">
            <div class="col-lg-2">
                <p>{{__('First Name')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                           value="{{$seller->first_name??old('first_name')}}" placeholder="First Name" required>
                    @error('first_name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Last Name')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                           value="{{$seller->last_name??old('last_name')}}" placeholder="Last Name" required>
                    @error('last_name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="user_type" value="1">
            <div class="col-lg-2">
                <p>{{__('Email')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{$seller->email??old('email')}}" placeholder="Email" required>
                    @error('email')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Mobile Number')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="mobile" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                           class="form-control @error('mobile') is-invalid @enderror"
                           value="{{$seller->mobile??old('mobile')}}" placeholder="Mobile Number" required>
                    @error('mobile')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Gender')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <select name="gender" class="form-select form-control @error('gender') is-invalid @enderror"
                            required>
                        <option value="">Select Gender</option>
                        <option value="1" @if($seller->gender=='1') selected @endif>Male</option>
                        <option value="2" @if($seller->gender=='2') selected @endif>Female</option>
                        <option value="0" @if($seller->gender=='0') selected @endif>Other</option>
                    </select>
                    @error('gender')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Image')}} </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                           name="image" accept="image/*">
                    @error('image')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Password')}} @if(Request::is('admin/sellers/create')) <span class="text-red">*</span> @endif </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="password" minlength="8" name="password"
                           class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                           @if(Request::is('admin/sellers/create')) required @endif>
                    @error('password')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Confirm Password')}} @if(Request::is('admin/sellers/create')) <span class="text-red">*</span> @endif </p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="password" minlength="8" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           placeholder="Confirm Password" @if(Request::is('admin/sellers/create')) required @endif>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-2">
                <p>{{__('Post Code')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="post_code" class="form-control @error('post_code') is-invalid @enderror"
                           value="{{$seller->post_code??old('post_code')}}"
                           placeholder="Post Code">
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('City')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                           value="{{$seller->city??old('city')}}" placeholder="City"
                           required>
                    @error('city')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Domain Name')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="domain_name" class="form-control @error('domain_name') is-invalid @enderror"
                           value="{{$seller->domain_name??old('domain_name')}}"
                           placeholder="Domain Name">
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Domain SSL')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <div class="form-switch">
                        <input name="domain_ssl_stat" type="hidden" value="0">
                        <input name="domain_ssl_stat" class="form-check-input" value="1"
                               @if($seller->domain_ssl_stat)checked @endif type="checkbox">
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <p>{{__('Address')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <textarea name="address" placeholder="Address" required
                              class="form-control">@if($seller->address){{$seller->address}}@else{{old('address')}}@endif</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="container content-title">
            <h4>{{__('Seller Business Information')}}</h4>
        </div>
        <div class="clearfix mt-3"></div>
        <div class="row">
            <div class="col-lg-2">
                <p>{{__('Company Name')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="company_name"
                           class="form-control @error('company_name') is-invalid @enderror"
                           value="@if($seller->company_name){{$seller->company_name}}@else{{old('company_name')}}@endif"
                           placeholder="Company Name" required>
                    @error('company_name')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Business Email')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="email" name="business_email"
                           class="form-control @error('business_email') is-invalid @enderror"
                           value="@if($seller->business_email){{$seller->business_email}}@else{{old('business_email')}}@endif"
                           placeholder="Business Email" required>
                    @error('business_email')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-2">
                <p>{{__('Business Mobile Number')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="number" name="business_mobile"
                           class="form-control @error('business_mobile') is-invalid @enderror"
                           value="@if($seller->business_mobile){{$seller->business_mobile}}@else{{old('business_mobile')}}@endif"
                           placeholder="Business Mobile Numbber" required>
                    @error('business_mobile')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('NID')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="number" name="nid" class="form-control @error('nid') is-invalid @enderror"
                           value="@if($seller->nid_no){{$seller->nid_no}}@else{{old('nid')}}@endif"
                           placeholder="NID">

                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Passport')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <input type="text" name="passport" class="form-control"
                           value="@if($seller->passport_no){{$seller->passport_no}}@else{{old('passport')}}@endif"
                           placeholder="Passport">
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Business Address')}} <span class="text-red">*</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <textarea name="business_address" class="form-control" required
                              placeholder="Business Address">@if($seller->business_address){{$seller->business_address}}@else{{old('business_address')}}@endif</textarea>
                    @error('business_address')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
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
                <div class="input-group">
                    <input type="number" step="0.1" min="0" max="100" name="seller_commission"
                           class="form-control @error('seller_commission') is-invalid @enderror"
                           value="@if($seller->commission && $seller->commission->seller_commission){{$seller->commission->seller_commission}}@else{{old('seller_commission')}}@endif"
                           placeholder="Seller Commission">
                    <span class="input-group-text">%</span>
                    @error('seller_commission')
                    <div id="seller_commission-error" class="error" for="seller_commission">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-2">
                <p>{{__('Note')}}</p>
            </div>
            <div class="col-lg-4">
                <div class="input-group">
                    <textarea name="note" placeholder="Note" maxlength="300"
                              class="form-control">@if($seller->commission && $seller->commission->remarks){{$seller->commission->remarks!="''"?$seller->commission->remarks:''}}@else{{old('note')}}@endif</textarea>
                    @error('note')
                    <div id="note-error" class="error" for="note">{{$message}}</div>
                    @enderror
                </div>
            </div>

            @if(Request::is('admin/sellers/create'))
                <div class="col-lg-10">
                    <div class="from-submit-btn">
                        <button type="submit" class="submit-btn" type="submit">{{__('Save')}}</button>
                    </div>
                </div>
            @else
                <div class="col-lg-10">
                    <div class="from-submit-btn">
                        <button type="submit" class="submit-btn" >{{__('Update')}}</button>
                    </div>
                </div>
        @endif
    </form>
</div>

@push('js')

    <script>

        (function ($) {
            "use strict";

            $(document).ready(function () {

                // validate form on keyup and submit
                $("#sellerForm").validate();

            });
        })(jQuery)

    </script>
@endpush
