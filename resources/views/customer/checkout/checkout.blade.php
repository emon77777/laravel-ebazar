@extends('frontend.layouts.front')

@section('title','Checkout')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('shop') }}">{{ __('Shop') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Checkout') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Billing Details Start -->
    <section class="billing-details">
        @if($errors->has('payment'))
            <div class="container mb-4">
                <div class="bg-white">
                    <h5 class="text-center text-danger p-2">{{ $errors->first('payment') }}</h5>
                </div>
            </div>
        @endif

        <form action="{{ route('customer.payment') }}" method="post">
            @csrf
            <input type="hidden" name="subTotal" value="{{ Cookie::get('subTotal') }}">
            <input type="hidden" name="shipping" value="{{ Cookie::get('totalShipping') }}">
            <input type="hidden" name="total" value="{{ Cookie::get('total') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login-form">
                            <h4>{{ __('Billing Details') }}</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input type="text" name="first_name" value="{{ $billing->first_name ?? auth('customer')->user()->first_name }}" class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('First Name') }} *</span>
                                        @if($errors->has('first_name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('first_name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input type="text" name="last_name" value="{{ $billing->last_name ?? auth('customer')->user()->last_name }}" class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Last Name') }} *</span>
                                        @if($errors->has('last_name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('last_name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="address_1" class="{{ $errors->has('address_1') ? 'is-invalid' : '' }}" value="{{ $billing->address_1 ?? old('address_1') }}">
                                        <span class="label">{{ __('Street Address') }} *</span>
                                        @if($errors->has('address_1'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('address_1') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="number" name="mobile" value="{{ $billing->mobile ?? auth('customer')->user()->mobile }}" class="{{ $errors->has('mobile') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Phone Number') }} *</span>
                                        @if($errors->has('mobile'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('mobile') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="email" value="{{ auth('customer')->user()->email }}" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Email Address') }} </span>
                                    </div>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <select name="country_id">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" @if($billing->country_id ?? '' === $country->id) selected @endif>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('country_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('country_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="number" name="post_code" class="{{ $errors->has('post_code') ? 'is-invalid' : '' }}" value="{{ $billing->post_code ?? old('post_code') }}">
                                        <span class="label">{{ __('Postcode/Zip') }} ({{ __('Option') }})</span>
                                        @if($errors->has('post_code'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('post_code') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="city" class="{{ $errors->has('city') ? 'is-invalid' : '' }}" value="{{ $billing->city ?? old('city') }}">
                                        <span class="label">{{ __('Town & City') }} </span>
                                        @if($errors->has('city'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('city') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <h4>{{ __('Shipping Details') }}</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="shipping_name" value="{{ old('shipping_name') ?? $shipping->shipping_name ?? '' }}" class="{{ $errors->has('shipping_name') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Full Name') }}*</span>
                                        @if($errors->has('shipping_name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('shipping_name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="address_line_one" value="{{ old('address_line_one') ?? $shipping->address_line_one ?? '' }}" class="{{ $errors->has('address_line_one') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Address Line One') }}*</span>
                                        @if($errors->has('address_line_one'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('address_line_one') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="address_line_two" value="{{ old('address_line_tow') ?? $shipping->address_line_two ?? '' }}" class="{{ $errors->has('address_line_two') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Address Line Two') }}</span>
                                        @if($errors->has('address_line_two'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('address_line_two') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="number" name="shipping_mobile" value="{{ $billing->mobile ?? auth('customer')->user()->mobile }}" class="{{ $errors->has('mobile') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Phone Number') }} *</span>
                                        @if($errors->has('mobile'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('mobile') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="shipping_email" value="{{ auth('customer')->user()->email }}" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                                        <span class="label">{{ __('Email Address') }} </span>
                                    </div>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="number" name="shipping_post" class="{{ $errors->has('shipping_post') ? 'is-invalid' : '' }}" value="{{ old('shipping_post') ?? $shipping->shipping_post ?? '' }}">
                                        <span class="label">{{ __('Postcode/Zip') }} ({{ __('Option') }})</span>
                                        @if($errors->has('shipping_post'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('shipping_post') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <input type="text" name="shipping_town" class="{{ $errors->has('shipping_town') ? 'is-invalid' : '' }}" value="{{ old('shipping_town') ?? $shipping->shipping_town ?? '' }}">
                                        <span class="label">{{ __('Town & City') }} </span>
                                        @if($errors->has('shipping_town'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('shipping_town') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <select name="shipping_country_id" id="">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" @if($shipping->shipping_country_id ?? '' === $country->id) selected @endif>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('shipping_country_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('shipping_country_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group">
                                        <textarea name="note" class="{{ $errors->has('note') }}">{{ old('note') }}</textarea>
                                        <span class="label">{{ __('Order note') }} </span>
                                        @if($errors->has('note'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('note') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="right-form">
                            <h4>{{ __('Promotional Code') }}</h4>
                            <p>{{ __('Have a coupon? (Will be available in next version.)') }}</p>
                            <div class="right-search input-group">
                                <input type="text" placeholder="Enter your coupon code" disabled>
                                <button class="btn-anime" disabled>{{ __('Apply Coupon') }}</button>
                            </div>
                            <div class="order-cart">
                                <h4>{{ __('Your Order') }}</h4>
                                <ul>
                                    <li>{{ __('Subtotal') }}<span>{{ currency(Cookie::get('subTotal'),2) }}</span></li>
                                    <li>{{ __('Shipping and Handing') }}
                                        @if(Cookie::get('totalShipping') == 0)
                                            <span>{{ __('Free') }}</span>
                                        @else
                                            <span>{{ currency(Cookie::get('totalShipping'),2) }}</span>
                                        @endif
                                    </li>
                                    <li>{{ __('Total') }}<span class="total">{{ currency(Cookie::get('total'),2) }}</span></li>
                                </ul>
                            </div>
                            <div class="payment-cart">
                                @if(gatewayOn('stripe'))
                                    <div class="input-group payment-option">
                                        <input type="radio" name="paymentOption" id="DirectBankTransferCheck" value="1" {{ old('paymentOption') == 1 ? 'checked' : '' }}>
                                        <label for="DirectBankTransferCheck">{{ __('Credit Card') }}</label>
                                        <p>{{ __('Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.') }}</p>
                                    </div>
                                @endif
                                @if(gatewayOn('paypal'))
                                    <div class="input-group payment-option">
                                        <input type="radio" name="paymentOption" id="paypalCheck" value="3" {{ old('paymentOption') == 3 ? 'checked' : '' }}>
                                        <label for="paypalCheck">{{ __('Paypal') }}</label>
                                        <p>{{ __('Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.') }}</p>
                                    </div>
                                @endif
                                    <div class="input-group payment-option">
                                        <input type="radio" name="paymentOption" id="razorpayCheck" value="2" {{ old('paymentOption') == 2 ? 'checked' : '' }}>
                                        <label for="razorpayCheck">{{ __('Razorpay') }}</label>
                                        <p>{{ __('Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.') }}</p>
                                    </div>
                                <div class="input-group payment-option">
                                    <input type="radio" name="paymentOption" id="cashOnDelivery" value="4"  {{ old('paymentOption') == 4 ? 'checked' : '' }}>
                                    <label for="cashOnDelivery">{{ __('Cash on Delivery') }}</label>
                                    <p>{{ __('Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.')}}</p>
                                </div>
                                <button type="submit" class="btn-anime">{{ __('Place Order') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- Billing Details End -->

@stop
