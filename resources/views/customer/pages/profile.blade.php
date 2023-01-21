@extends('frontend.layouts.front')

@section('title','Profile')

@section('content')

    <section class="maan-user-dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-md-5 wow fadeInUp" >
                    <div class="maan-author-profile">
                        <div class="user-info">
                            <div class="maan-user-thumb">
                                <label for="file">
                                    <img src="{{ asset('frontend/img/users') }}/{{ $user->image }}" alt="{{ $user->username }}" id="blah">
                                </label>
                            </div>
                            <form action="{{ route('profile.image',$user->id) }}" method="post" class="text-center" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="file" class="profile-file" name="image" onchange="readURL(this)">
                                <button type="submit" class="btn btn-sm btn-outline-success">{{ __('Update Image') }}</button>
                            </form>
                            <div class="user-title">
                                <a href="#" class="user-name">{{ $user->username }}</a>
                                <a href="tel:317-216-5955" class="phone">{{ __('Last Login') }}: {{ $user->last_login_datetime ? $user->last_login_datetime->format('Y-m-d') : '' }}</a>
                            </div>
                        </div>
                        <ul class="nav flex-column" id="myTab" role="tablist">
                            <li><a class="active" href="#" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"><span><i class="flaticon-user-1"></i></span>{{ __('Basic Information') }}</a></li>
                            <li><a href="#" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" ><span><i class="flaticon-shopping-list"></i></span>{{ __('My Orders')}}</a></li>
                            <li><a href="#" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"  ><span><i class="flaticon-lock"></i></span>{{ __('Change Password') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9 col-lg-9 col-md-7 wow fadeInUp" data-wow-delay="0.3s">
                    @if(Session::has('error'))
                        <h4 class="text-danger">{{ Session::get('error') }}</h4>
                    @endif
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home">

                            <div class="maan-personal-information">
                                <div class="maan-info-header">
                                    <h4>{{ __('Personal Information') }}</h4>
                                    <a href="#infoEditModal" class="save-btb edit-btn maan-btn link-anime" data-bs-toggle="modal" data-bs-target="#infoEditModal">{{ __('Edit') }}</a>
                                </div>
                                @if($errors->any())
                                    <ul class="text-center">
                                        @foreach($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="maan-user-details">
                                    <ul>
                                        <li>{{ __('First Name') }}: <span>{{ $user->first_name }}</span></li>
                                        <li>{{ __('Last Name') }}: <span>{{ $user->last_name }}</span></li>
                                        <li>{{ __('Contact Number') }}: <span>{{ $user->mobile }}</span></li>
                                        <li>{{ __('Gender') }}:  <span> {{ userGender($user->gender) }}</span></li>
                                        <li>{{ __('Date of Birth') }}:  <span>  {{ $user->dob ? $user->dob->format('Y-m-d') : '' }}</span></li>
                                        <li>{{ __('Member Since') }}:  <span>  {{ $user->created_at->diffForHumans() }}</span></li>
                                    </ul>
                                </div>

                                <div class="maan-user-address">
                                    <div class="maan-info-header">
                                        <h4>{{ __('Address') }}</h4>
                                        <a href="#addressEditModal" class="save-btb edit-btn maan-btn link-anime" data-bs-toggle="modal" data-bs-target="#addressEditModal">{{ __('Edit') }}</a>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="maan-address">
                                                <h5>{{ __('Shipping Address') }}: <a href="#shippingEditModal" class="" data-bs-toggle="modal" data-bs-target="#shippingEditModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8.424 12.282l4.402 4.399-5.826 1.319 1.424-5.718zm15.576-6.748l-9.689 9.804-4.536-4.536 9.689-9.802 4.536 4.534zm-6 8.916v6.55h-16v-12h6.743l1.978-2h-10.721v16h20v-10.573l-2 2.023z"/></svg></a></h5>
                                                <p>
                                                    {{ $shipping->address_line_one ?? '' }}<br>
                                                    {{ $shipping->address_line_two ?? '' }}
                                                </p>
                                                <p>{{ __('Post Code') }}: {{ $shipping->shipping_post ?? '' }}</p>
                                                <p>{{ __('City') }}: {{ $shipping->shipping_town ?? '' }}</p>
                                                <p>{{ __('Country') }}: {{ $shipping->country->name ?? '' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            @if($errors->any())
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li class="text-danger">{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            <div class="maan-address">
                                                <h5 class="blue">{{ __('Billing Address') }}:</h5>
                                                <p>{{ $billing->address_1 ?? '' }}</p>
                                                <p>{{ $billing->address_2 ?? '' }}</p>
                                                <p>{{ __('Post Code') }}: {{ $billing->post_code ?? '' }}</p>
                                                <p>{{ __('City') }}: {{ $billing->user_city ?? '' }}</p>
                                                <p>{{ __('Mobile') }}: {{ $billing->mobile ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <div class="maan-order-history">
                                <div class="maan-info-header">
                                    <h4>{{ __('My Orders History') }}</h4>
                                </div>
                                <div class="maan-find-history">
                                    <section class="card-table p-0">
                                        <div class="container p-0">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Order no.') }}</th>
                                                    <th scope="col" @class(['text-center'])>{{ __('Items') }}</th>
                                                    <th scope="col">{{ __('Price') }}</th>
                                                    <th scope="col">{{ __('Quantity') }}</th>
                                                    <th >{{ __('Total Price') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($orders as $order)
                                                    @if($order->product)
                                                        <tr>
                                                            <td class="text-dark">{{ $order->order->order_no ?? '' }}</td>
                                                            <td scope="row" class="text-center">
                                                                <img src="{{ asset('uploads/products/galleries') }}/{{ $order->product->images->first()->image }}" alt="{{ $order->product->name }}">
                                                                <br>
                                                                {{ $order->product->name }}
                                                            </td>
                                                            <td>{{ currencyRaw($order->pro_price,$order->currency_id,$order->exchange_rate,2) }}</td>
                                                            <td class="table-quantity">
                                                                {{ $order->qty }}
                                                            </td>
                                                            <td>{{ currencyRaw($order->total_price,$order->currency_id,$order->exchange_rate,2) }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div class="checkout-btn"></div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact">
                            <div class="maan-order-history login-form p-0">
                                <div class="maan-info-header">
                                    <h4 class="mb-0">{{ __('Change Password') }}</h4>
                                </div>
                                <form action="{{ route('customer.change-password') }}" class="maan-password-change " method="post">
                                    @csrf
                                    <div class="input-group mypass">
                                        <input name="old_password" id="myPass" type="password">
                                        <span class="label">{{ __('Old Password') }}</span>
                                        <button type="button" class="show-pass">
                                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.992 511.992"><path d="M510.096,249.937c-4.032-5.867-100.928-143.275-254.101-143.275C124.56,106.662,7.44,243.281,2.512,249.105
			c-3.349,3.968-3.349,9.792,0,13.781C7.44,268.71,124.56,405.329,255.995,405.329S504.549,268.71,509.477,262.886
			C512.571,259.217,512.848,253.905,510.096,249.937z M255.995,383.996c-105.365,0-205.547-100.48-230.997-128
			c25.408-27.541,125.483-128,230.997-128c123.285,0,210.304,100.331,231.552,127.424
			C463.013,282.065,362.256,383.996,255.995,383.996z"></path><path d="M255.995,170.662c-47.061,0-85.333,38.272-85.333,85.333s38.272,85.333,85.333,85.333s85.333-38.272,85.333-85.333
			S303.056,170.662,255.995,170.662z M255.995,319.996c-35.285,0-64-28.715-64-64s28.715-64,64-64s64,28.715,64,64
			S291.28,319.996,255.995,319.996z"></path></svg>
                                            <svg class="eye-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001"><path d="M316.332,195.662c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.944,0,15.083
			c12.075,12.075,18.752,28.139,18.752,45.248c0,35.285-28.715,64-64,64c-17.109,0-33.173-6.656-45.248-18.752
			c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.139-4.16,10.923,0,15.083c16.085,16.128,37.525,25.003,60.331,25.003
			c47.061,0,85.333-38.272,85.333-85.333C341.334,233.187,332.46,211.747,316.332,195.662z"></path><path d="M270.87,172.131c-4.843-0.853-9.792-1.472-14.869-1.472c-47.061,0-85.333,38.272-85.333,85.333
			c0,5.077,0.619,10.027,1.493,14.869c0.917,5.163,5.419,8.811,10.475,8.811c0.619,0,1.237-0.043,1.877-0.171
			c5.781-1.024,9.664-6.571,8.64-12.352c-0.661-3.627-1.152-7.317-1.152-11.157c0-35.285,28.715-64,64-64
			c3.84,0,7.531,0.491,11.157,1.131c5.675,1.152,11.328-2.859,12.352-8.64C280.534,178.702,276.652,173.155,270.87,172.131z"></path><path d="M509.462,249.102c-2.411-2.859-60.117-70.208-139.712-111.445c-5.163-2.709-11.669-0.661-14.379,4.587
			c-2.709,5.227-0.661,11.669,4.587,14.379c61.312,31.744,110.293,81.28,127.04,99.371c-25.429,27.541-125.504,128-230.997,128
			c-35.797,0-71.872-8.64-107.264-25.707c-5.248-2.581-11.669-0.341-14.229,4.971c-2.581,5.291-0.341,11.669,4.971,14.229
			c38.293,18.496,77.504,27.84,116.523,27.84c131.435,0,248.555-136.619,253.483-142.443
			C512.854,258.915,512.833,253.091,509.462,249.102z"></path><path d="M325.996,118.947c-24.277-8.171-47.829-12.288-69.995-12.288c-131.435,0-248.555,136.619-253.483,142.443
			c-3.115,3.669-3.371,9.003-0.597,12.992c1.472,2.112,36.736,52.181,97.856,92.779c1.813,1.216,3.84,1.792,5.888,1.792
			c3.435,0,6.827-1.664,8.875-4.8c3.264-4.885,1.92-11.52-2.987-14.763c-44.885-29.845-75.605-65.877-87.104-80.533
			c24.555-26.667,125.291-128.576,231.552-128.576c19.861,0,41.131,3.755,63.189,11.157c5.589,2.005,11.648-1.088,13.504-6.699
			C334.572,126.862,331.585,120.825,325.996,118.947z"></path><path d="M444.865,67.128c-4.16-4.16-10.923-4.16-15.083,0L67.116,429.795c-4.16,4.16-4.16,10.923,0,15.083
			c2.091,2.069,4.821,3.115,7.552,3.115c2.731,0,5.461-1.045,7.531-3.115L444.865,82.211
			C449.025,78.051,449.025,71.288,444.865,67.128z"></path></svg>
                                        </button>
                                    </div>
                                    <div class="input-group conpass">
                                        <input name="password" id="conPass" type="password">
                                        <span class="label valu-push">{{ __('Enter New Password') }}</span>
                                        <button type="button" class="show-pass">
                                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.992 511.992"><path d="M510.096,249.937c-4.032-5.867-100.928-143.275-254.101-143.275C124.56,106.662,7.44,243.281,2.512,249.105
			c-3.349,3.968-3.349,9.792,0,13.781C7.44,268.71,124.56,405.329,255.995,405.329S504.549,268.71,509.477,262.886
			C512.571,259.217,512.848,253.905,510.096,249.937z M255.995,383.996c-105.365,0-205.547-100.48-230.997-128
			c25.408-27.541,125.483-128,230.997-128c123.285,0,210.304,100.331,231.552,127.424
			C463.013,282.065,362.256,383.996,255.995,383.996z"></path><path d="M255.995,170.662c-47.061,0-85.333,38.272-85.333,85.333s38.272,85.333,85.333,85.333s85.333-38.272,85.333-85.333
			S303.056,170.662,255.995,170.662z M255.995,319.996c-35.285,0-64-28.715-64-64s28.715-64,64-64s64,28.715,64,64
			S291.28,319.996,255.995,319.996z"></path></svg>
                                            <svg class="eye-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001"><path d="M316.332,195.662c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.944,0,15.083
			c12.075,12.075,18.752,28.139,18.752,45.248c0,35.285-28.715,64-64,64c-17.109,0-33.173-6.656-45.248-18.752
			c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.139-4.16,10.923,0,15.083c16.085,16.128,37.525,25.003,60.331,25.003
			c47.061,0,85.333-38.272,85.333-85.333C341.334,233.187,332.46,211.747,316.332,195.662z"></path><path d="M270.87,172.131c-4.843-0.853-9.792-1.472-14.869-1.472c-47.061,0-85.333,38.272-85.333,85.333
			c0,5.077,0.619,10.027,1.493,14.869c0.917,5.163,5.419,8.811,10.475,8.811c0.619,0,1.237-0.043,1.877-0.171
			c5.781-1.024,9.664-6.571,8.64-12.352c-0.661-3.627-1.152-7.317-1.152-11.157c0-35.285,28.715-64,64-64
			c3.84,0,7.531,0.491,11.157,1.131c5.675,1.152,11.328-2.859,12.352-8.64C280.534,178.702,276.652,173.155,270.87,172.131z"></path><path d="M509.462,249.102c-2.411-2.859-60.117-70.208-139.712-111.445c-5.163-2.709-11.669-0.661-14.379,4.587
			c-2.709,5.227-0.661,11.669,4.587,14.379c61.312,31.744,110.293,81.28,127.04,99.371c-25.429,27.541-125.504,128-230.997,128
			c-35.797,0-71.872-8.64-107.264-25.707c-5.248-2.581-11.669-0.341-14.229,4.971c-2.581,5.291-0.341,11.669,4.971,14.229
			c38.293,18.496,77.504,27.84,116.523,27.84c131.435,0,248.555-136.619,253.483-142.443
			C512.854,258.915,512.833,253.091,509.462,249.102z"></path><path d="M325.996,118.947c-24.277-8.171-47.829-12.288-69.995-12.288c-131.435,0-248.555,136.619-253.483,142.443
			c-3.115,3.669-3.371,9.003-0.597,12.992c1.472,2.112,36.736,52.181,97.856,92.779c1.813,1.216,3.84,1.792,5.888,1.792
			c3.435,0,6.827-1.664,8.875-4.8c3.264-4.885,1.92-11.52-2.987-14.763c-44.885-29.845-75.605-65.877-87.104-80.533
			c24.555-26.667,125.291-128.576,231.552-128.576c19.861,0,41.131,3.755,63.189,11.157c5.589,2.005,11.648-1.088,13.504-6.699
			C334.572,126.862,331.585,120.825,325.996,118.947z"></path><path d="M444.865,67.128c-4.16-4.16-10.923-4.16-15.083,0L67.116,429.795c-4.16,4.16-4.16,10.923,0,15.083
			c2.091,2.069,4.821,3.115,7.552,3.115c2.731,0,5.461-1.045,7.531-3.115L444.865,82.211
			C449.025,78.051,449.025,71.288,444.865,67.128z"></path></svg>
                                        </button>
                                    </div>
                                    <div class="input-group newpass">
                                        <input name="password_confirmation" id="newPass" type="password">
                                        <span class="label valu-push">{{ __('Enter New Password') }}</span>
                                        <button type="button" class="show-pass">
                                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.992 511.992"><path d="M510.096,249.937c-4.032-5.867-100.928-143.275-254.101-143.275C124.56,106.662,7.44,243.281,2.512,249.105
			c-3.349,3.968-3.349,9.792,0,13.781C7.44,268.71,124.56,405.329,255.995,405.329S504.549,268.71,509.477,262.886
			C512.571,259.217,512.848,253.905,510.096,249.937z M255.995,383.996c-105.365,0-205.547-100.48-230.997-128
			c25.408-27.541,125.483-128,230.997-128c123.285,0,210.304,100.331,231.552,127.424
			C463.013,282.065,362.256,383.996,255.995,383.996z"></path><path d="M255.995,170.662c-47.061,0-85.333,38.272-85.333,85.333s38.272,85.333,85.333,85.333s85.333-38.272,85.333-85.333
			S303.056,170.662,255.995,170.662z M255.995,319.996c-35.285,0-64-28.715-64-64s28.715-64,64-64s64,28.715,64,64
			S291.28,319.996,255.995,319.996z"></path></svg>
                                            <svg class="eye-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001"><path d="M316.332,195.662c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.16-4.16,10.944,0,15.083
			c12.075,12.075,18.752,28.139,18.752,45.248c0,35.285-28.715,64-64,64c-17.109,0-33.173-6.656-45.248-18.752
			c-4.16-4.16-10.923-4.16-15.083,0c-4.16,4.139-4.16,10.923,0,15.083c16.085,16.128,37.525,25.003,60.331,25.003
			c47.061,0,85.333-38.272,85.333-85.333C341.334,233.187,332.46,211.747,316.332,195.662z"></path><path d="M270.87,172.131c-4.843-0.853-9.792-1.472-14.869-1.472c-47.061,0-85.333,38.272-85.333,85.333
			c0,5.077,0.619,10.027,1.493,14.869c0.917,5.163,5.419,8.811,10.475,8.811c0.619,0,1.237-0.043,1.877-0.171
			c5.781-1.024,9.664-6.571,8.64-12.352c-0.661-3.627-1.152-7.317-1.152-11.157c0-35.285,28.715-64,64-64
			c3.84,0,7.531,0.491,11.157,1.131c5.675,1.152,11.328-2.859,12.352-8.64C280.534,178.702,276.652,173.155,270.87,172.131z"></path><path d="M509.462,249.102c-2.411-2.859-60.117-70.208-139.712-111.445c-5.163-2.709-11.669-0.661-14.379,4.587
			c-2.709,5.227-0.661,11.669,4.587,14.379c61.312,31.744,110.293,81.28,127.04,99.371c-25.429,27.541-125.504,128-230.997,128
			c-35.797,0-71.872-8.64-107.264-25.707c-5.248-2.581-11.669-0.341-14.229,4.971c-2.581,5.291-0.341,11.669,4.971,14.229
			c38.293,18.496,77.504,27.84,116.523,27.84c131.435,0,248.555-136.619,253.483-142.443
			C512.854,258.915,512.833,253.091,509.462,249.102z"></path><path d="M325.996,118.947c-24.277-8.171-47.829-12.288-69.995-12.288c-131.435,0-248.555,136.619-253.483,142.443
			c-3.115,3.669-3.371,9.003-0.597,12.992c1.472,2.112,36.736,52.181,97.856,92.779c1.813,1.216,3.84,1.792,5.888,1.792
			c3.435,0,6.827-1.664,8.875-4.8c3.264-4.885,1.92-11.52-2.987-14.763c-44.885-29.845-75.605-65.877-87.104-80.533
			c24.555-26.667,125.291-128.576,231.552-128.576c19.861,0,41.131,3.755,63.189,11.157c5.589,2.005,11.648-1.088,13.504-6.699
			C334.572,126.862,331.585,120.825,325.996,118.947z"></path><path d="M444.865,67.128c-4.16-4.16-10.923-4.16-15.083,0L67.116,429.795c-4.16,4.16-4.16,10.923,0,15.083
			c2.091,2.069,4.821,3.115,7.552,3.115c2.731,0,5.461-1.045,7.531-3.115L444.865,82.211
			C449.025,78.051,449.025,71.288,444.865,67.128z"></path></svg>
                                        </button>
                                    </div>
                                    <button type="submit" class="btn-anime">{{ __('Save Password') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Edit Modal -->
    <div class="modal fade" id="infoEditModal" tabindex="-1" aria-labelledby="infoEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-btn-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <form class="login-form" action="{{ route('profile.update',$user->id) }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="first_name" class="" value="{{ $user->first_name }}">
                            <span class="label">{{ __('First Name') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="last_name" class="" value="{{ $user->last_name }}">
                            <span class="label">{{ __('Last Name') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="mobile" class="" value="{{ $user->mobile }}">
                            <span class="label">{{ __('Contact Number') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="date" name="dob" class="" value="{{ $user->dob ? $user->dob->format('Y-m-d') : '' }}">
                            <span class="label">{{ __('Date of Birth') }} *</span>
                        </div>
                        <div class="input-group">
                            <select name="gender" class="form-control">
                                <option value="0">{{ __('Gender') }}</option>
                                <option value="1" {{ $user->gender == '1' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                <option value="2"  {{ $user->gender == '2' ? 'selected' : '' }}>{{ __('Female') }}</option>
                            </select>
                        </div>
                        <button class="btn-anime" type="submit">{{ __('Save Change') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Edit Modal -->
    <div class="modal fade" id="addressEditModal" tabindex="-1" aria-labelledby="addressEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-btn-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <form class="login-form" action="{{ route('profile.billing') }}" method="post">
                        @csrf
                        <h4>{{ __('Billing Address') }}</h4>
                        <div class="input-group">
                            <input type="text" name="first_name" class="" value="{{ $billing->first_name }}">
                            <span class="label">{{ __('First Name') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="last_name" class="" value="{{ $billing->last_name }}">
                            <span class="label">{{ __('Last Name') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="address_1" class="" value="{{ $billing->address_1 }}">
                            <span class="label">{{ __('Address Line One') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="number" name="post_code" class="" value="{{ $billing->post_code }}">
                            <span class="label">{{ __('Post Code') }} </span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="user_city" class="" value="{{ $billing->user_city }}">
                            <span class="label">{{ __('City') }} </span>
                        </div>
                        <div class="input-group">
                            <input type="number" name="mobile" class="" value="{{ $billing->mobile }}">
                            <span class="label">{{ __('Mobile') }} </span>
                        </div>
                        <div class="input-group">
                            <input type="email" name="email" class="" value="{{ $billing->email }}">
                            <span class="label">{{ __('Email') }} </span>
                        </div>
                        <div class="input-group">
                            <select name="country_id" id="" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if($country->id == $billing->country_id) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn-anime" type="submit">{{ __('Save Change') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipping Address Edit Modal -->
    <div class="modal fade" id="shippingEditModal" tabindex="-1" aria-labelledby="shippingEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="modal-btn-close btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <form class="login-form" action="{{ route('profile.shipping') }}" method="post">
                        @csrf
                        <h4>{{ __('Shipping Address') }}</h4>
                        <div class="input-group">
                            <input type="text" name="shipping_name" class="" value="{{ $shipping->shipping_name }}">
                            <span class="label">{{ __('Shipping Name') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="address_line_one" class="" value="{{ $shipping->address_line_one }}">
                            <span class="label">{{ __('Address Line One') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="address_line_two" class="" value="{{ $shipping->address_line_two }}" required>
                            <span class="label">{{ __('Address Line Two') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="number" name="shipping_mobile" class="" value="{{ $shipping->shipping_mobile }}">
                            <span class="label">{{ __('Mobile') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="email" name="shipping_email" class="" value="{{ $shipping->shipping_email }}">
                            <span class="label">{{ __('Email') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="number" name="shipping_post" class="" value="{{ $shipping->shipping_post }}">
                            <span class="label">{{ __('Post Code') }} *</span>
                        </div>
                        <div class="input-group">
                            <input type="text" name="shipping_town" class="" value="{{ $shipping->shipping_town }}">
                            <span class="label">{{ __('Town') }} *</span>
                        </div>
                        <div class="input-group">
                            <select name="shipping_country_id" id="" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if($country->id == $shipping->shipping_country_id) selected @endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn-anime" type="submit">{{ __('Save Change') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        function readURL(input) {
            "use strict";
            if (input.files && input.files[0]) {

                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result).width(150).height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        @if(Session::has('success'))
        swal("{{ __('Success!') }}", "{{ Session::get('success') }}", "success");
        @endif
    </script>
@stop
