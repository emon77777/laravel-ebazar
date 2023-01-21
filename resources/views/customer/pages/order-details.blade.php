@extends('customer.layouts.master')

@section('content')
    <div class="container">
        <div class="maan-mybazar-order-details">
            <h3>{{ __('Order Details') }}</h3>
            <div class="maan-order-heading">
                <div class="order-side">
                    <h6>{{ __('Order') }} #{{ $order->order->order_no }}</h6>
                    <p>{{ __('Placed On') }} <span>{{ $order->created_at->format('d M Y') }}</span> <span>{{ $order->created_at->format('H:i:s') }}</span></p>
                </div>
                <div class="price-side">
                    <p>{{ __("Total") }}: <span>{{ orderCurrency($order->currency_id,$order->grand_total,2) }}</span></p>
                </div>
            </div>
            <div class="mybazar-order-processing">
                <div class="processing-heading">
                    <div class="left-side">
                        <p>{{ __('Package 1') }}</p>
                        <span>{{ __('Sold by') }} <a href="">{{ maanAppearance('meta_title') }}</a></span>
                    </div>
                    <div class="right-side">
                        <a href="">{{ __('Chat Now') }}</a>
                    </div>
                </div>
                <div class="mybazar-processing-body">
                    <div class="mybazar-delivery-title">
                        <p>{{ __('Estimated Delivery day') }} {{ $order->product->estimated_shipping_days }}</p>
                        <span>{{ __('Standard') }}</span>
                    </div>
                    <div class="processing-timeline">
                        <ul class="mybazar-timeline">
                            @if($order->order_stat == 7)
                                <li class="active-tl"><span>{{ __('Processing') }}</span></li>
                                <li class="active-tl"><span>{{ __('Canceled') }}</span></li>
                            @else
                                <li class="active-tl" ><span>{{ __('Processing') }}</span></li>
                                <li class="{{ $order->order_stat >= 5 ? 'active-tl' : '' }}"><span>{{ __('Shipped') }}</span></li>
                                <li class="{{ $order->order_stat == 6 ? 'active-tl' : '' }}"><span>{{ __('Delivered') }}</span></li>
                            @endif
                        </ul>
                    </div>
                    <div class="maan-timeline-tab-content">
                        <div class="timeline-content tab-active">
                            @foreach($order->timelines as $timeline)
                                <p>{{ $timeline->order_stat_datetime->format('d M Y - H:i') }} <span>{{ $timeline->status->name }} - {{ $timeline->order_stat_desc }}</span></p>
                                {{--                            <a href="">View More</a>--}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mybazar-product-items-wrp">
                    <div class="mybazar-product-items-with-details">
                        <div class="thumb">
                            <img src="{{ asset('uploads/products/galleries') }}/{{ $order->product->images->first()->image }}" alt="{{ $order->product->name }}">
                            <div class="text">
                                <p>{{ $order->product->name }}</p>
                                <p>
                                    @if($order->color)
                                        <span class="badge bg-light text-dark">Color: {{ $order->color }}</span>
                                    @endif
                                    @if($order->size)
                                        <span class="badge bg-light text-dark">Size: {{ $order->size }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="price">
                            <p>{{ orderCurrency($order->currency_id,$order->total_price,2) }} + {{ $order->shipping_cost > 0 ? orderCurrency($order->currency_id,$order->total_shipping_cost,2) : 'Free' }} </p>
                        </div>
                        <div class="qty">
                            <p>{{ __('Qty') }}: {{ $order->qty }}</p>
                        </div>
                        @if($order->order_stat <= 2)
                        <div class="cancel-btn">
                            <a href="{{ route('order.order-cancel',$order->id) }}">{{ __('Cancel') }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
