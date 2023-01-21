@extends('frontend.layouts.front')

@section('title','Success')

@section('content')
    <section class="shop-list">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-lg-6 text-center">
                    <h3>{{ __('Thank you for your purchase') }}</h3>
                    <p class="h4">{{ __('Your order no is') }} <b>{{ session('order')->order_no }}</b></p>
                    <h3>{{ currency(session('order')->total_price,2) }}</h3>
                    <p class="mt-5"></p>
                    <table class="table table-bordered">
                        @foreach(session('items') as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset('uploads/products/galleries') }}/{{ CartItem::thumbnail($item->id) }}" height="75" alt="{{ CartItem::thumbnail($item->id) }}">
                                    <br>
                                    {{ CartItem::name($item->id) }}
                                </td>
                                <td>{{ __('Estimated shipping ') }} {{ CartItem::estimatedShippingDays($item->id)  }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="mybazar-payment-delivery-date-link">
                        <p>{{ __('For More Details, Track Your Delivery Status Under') }} <span>{{ __('My Account') }} > {{ __('Order') }}</span> <a href="{{ route('customer.order') }}">{{ __('View Order')}}</a></p>
                    </div>
                    <p class="my-5">{{ __('We have sent you an email at ') }}{{ auth('customer')->user()->email }}</p>
                </div>
            </div>
        </div>
    </section>

@stop
