@extends('customer.layouts.master')

@section('title','Dashboard')

@section('content')
    <div class="maan-main-content">
        <div class="maan-state-overview maan-layout-style-one">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="maan-counter-wpr grid-4">
                            <a href="javascript:orderList(0)" class="maan-counter-box">
                                <div class="maan-icon maan-radius maan-icon-clr-lightdanger">
                                    <i> <img src="{{ asset('customer/img/icons/1.svg') }}" alt="Icon"></i>
                                </div>
                                <div class="maan-desc">
                                    <div class="maan-counter">
                                        <span class="maan-counter-title counter">{{ orderCount(0) }}</span>
                                    </div>
                                    <p class="maan-counter-content">{{ __('Total Order') }}</p>
                                </div>
                            </a>
                            <a href="javascript:orderList(5)" class="maan-counter-box">
                                <div class="maan-icon maan-radius maan-icon-clr-lightblue">
                                    <i> <img src="{{ asset('customer/img/icons/track-blue.svg') }}" alt="Icon"></i>
                                </div>
                                <div class="maan-desc">
                                    <div class="maan-counter">
                                        <div class="maan-counter">
                                            <span class="maan-counter-title counter">{{ orderCount(5) }}</span>
                                        </div>
                                        <p class="maan-counter-content">{{ __('Order Shipped') }}</p>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:orderList(6)" class="maan-counter-box">
                                <div class="maan-icon maan-radius maan-icon-clr-lightgreen">
                                    <i> <img src="{{ asset('customer/img/icons/track-green.svg') }}" alt="Icon"></i>
                                </div>
                                <div class="maan-desc">
                                    <div class="maan-counter">
                                        <span class="maan-counter-title counter">{{ orderCount(6) }}</span>
                                    </div>
                                    <p class="maan-counter-content">{{ __('Order Delivered') }}</p>
                                </div>
                            </a>
                            <a href="javascript:orderList(7)" class="maan-counter-box">
                                <div class="maan-icon maan-radius maan-icon-clr-lightred">
                                    <i> <img src="{{ asset('customer/img/icons/order-cancel.svg') }}" alt="Icon"></i>
                                </div>
                                <div class="maan-desc">
                                    <div class="maan-counter">
                                        <span class="maan-counter-title counter">{{ orderCount(7) }}</span>
                                    </div>
                                    <p class="maan-counter-content">{{ __('Order Canceled') }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="maan-content-wpr">
                    <!-- Order list will appeared here -->
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        "use strict";
        var xhr = new XMLHttpRequest();
        function orderList(stat,page){
            var csrf = "{{ csrf_token() }}"
            if(xhr !== 'undefined'){
                xhr.abort(); //stop existing ajax request if new request has been sent to server
            }
            console.log('Stat: '+stat);
            console.log('Page: '+page);
            $.ajax({
                url : "{{ route('customer.order.list') }}",
                data : {_token:csrf,stat:stat,page:page},
                type : "post"
            }).done(function(e){
                $(".maan-content-wpr").html(e);
            })
        }

        $(document).ready(function(){
            orderList(0);
        })

        $(document).on('click','.pagination-bar a',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var page = url.split('page=')[1];
            var stat = $(this).data('stat');
            orderList(stat,page);
        })
    </script>
@stop
