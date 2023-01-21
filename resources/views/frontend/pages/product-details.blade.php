@extends('frontend.layouts.front')

@section('title',$product->name)

@section('meta_title',$product->meta_title ?? $product->name)

@section('meta_description',$product->meta_description ?? '')

@section('meta_image',$product->meta_image)

@section('meta_url',url()->full())

@section('meta_price',currency($product->unit_price,2))

@section('meta_color','Black')

@section('content')

    <!-- Breadcrumb Start -->
    <nav class="breadcrumb-manu" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url('shop') }}">{{ __('Shop') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('Product') }}</li>
            </ol>
        </div>
    </nav>
    <!-- Breadcrumb End -->
    <!-- Shop Details Start -->
    <section class="shop-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="row product-slider">
                        <div class="col-lg-3 order-2 order-lg-0 product-small-img">
                            @foreach($product->images as $image)
                                <div class="main-img">
                                    <img src="{{ asset('uploads/products/galleries/'.$image->image) }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-9 order-0  product-big-img">
                            @foreach($product->images as $image)
                                <div class="main-img">
                                    <img src="{{ asset('uploads/products/galleries/'.$image->image) }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="product-item-details">
                        <div class="product-title">
                            <h4>{{ $product->name }}</h4>
                        </div>
                        <div class="star-rating">
                            <div class="rateit" data-rateit-value="{{ $rating }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                            <a href="#">({{ $product->reviews->count() }} {{ __('Review/s') }})</a>
                        </div>
                        <div class="price">
                            @if(hasPromotion($product->id))
                                <h4>{{ currency(promotionPrice($product->id),2) }} <del>{{ currency($product->unit_price,2) }}</del></h4>
                            @else
                                @if($product->discount > 0)
                                    <h4>{{ currency(($product->unit_price - $product->discount),2) }} <del>{{ currency($product->unit_price,2) }}</del></h4>
                                @else
                                    <h4>{{ currency($product->unit_price,2) }}</h4>
                                @endif
                            @endif
                        </div>

                        <div class="skustock d-flex align-items-center">
                            @if($product->sku)
                                <div class="stock-id">{{ __('SKU') }} : <span>{{ $product->sku }}</span></div>
                            @endif
                            <div class="product-stock out-stock">
                                @if($product->details)
                                    @if($product->details->is_show_stock_quantity == 0)
                                        <span class="icon">
                                        <svg class="check-mark" viewBox="0 0 512 512"><path d="M437.019,74.98C388.667,26.629,324.38,0,256,0C187.619,0,123.331,26.629,74.98,74.98C26.628,123.332,0,187.62,0,256
			s26.628,132.667,74.98,181.019C123.332,485.371,187.619,512,256,512c68.38,0,132.667-26.629,181.019-74.981
			C485.371,388.667,512,324.38,512,256S485.371,123.333,437.019,74.98z M256,482C131.383,482,30,380.617,30,256S131.383,30,256,30
			s226,101.383,226,226S380.617,482,256,482z"/><path d="M378.305,173.859c-5.857-5.856-15.355-5.856-21.212,0.001L224.634,306.319l-69.727-69.727
			c-5.857-5.857-15.355-5.857-21.213,0c-5.858,5.857-5.858,15.355,0,21.213l80.333,80.333c2.929,2.929,6.768,4.393,10.606,4.393
			c3.838,0,7.678-1.465,10.606-4.393l143.066-143.066C384.163,189.215,384.163,179.717,378.305,173.859z"/></svg> <svg class="close-mark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.995 511.995"><path d="M437.126,74.939c-99.826-99.826-262.307-99.826-362.133,0C26.637,123.314,0,187.617,0,256.005
			s26.637,132.691,74.993,181.047c49.923,49.923,115.495,74.874,181.066,74.874s131.144-24.951,181.066-74.874
			C536.951,337.226,536.951,174.784,437.126,74.939z M409.08,409.006c-84.375,84.375-221.667,84.375-306.042,0
			c-40.858-40.858-63.37-95.204-63.37-153.001s22.512-112.143,63.37-153.021c84.375-84.375,221.667-84.355,306.042,0
			C493.435,187.359,493.435,324.651,409.08,409.006z"></path><path d="M341.525,310.827l-56.151-56.071l56.151-56.071c7.735-7.735,7.735-20.29,0.02-28.046
			c-7.755-7.775-20.31-7.755-28.065-0.02l-56.19,56.111l-56.19-56.111c-7.755-7.735-20.31-7.755-28.065,0.02
			c-7.735,7.755-7.735,20.31,0.02,28.046l56.151,56.071l-56.151,56.071c-7.755,7.735-7.755,20.29-0.02,28.046
			c3.868,3.887,8.965,5.811,14.043,5.811s10.155-1.944,14.023-5.792l56.19-56.111l56.19,56.111
			c3.868,3.868,8.945,5.792,14.023,5.792c5.078,0,10.175-1.944,14.043-5.811C349.28,331.117,349.28,318.562,341.525,310.827z"></path></svg></span>
                                        <span class="text">{{ __('Not Available') }}</span>
                                    @else
                                        <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.25 8.891l-1.421-1.409-6.105 6.218-3.078-2.937-1.396 1.436 4.5 4.319 7.5-7.627z" stroke="green"/></svg>
                                    <span class="text">{{ __('In Stock') }}</span>
                                @endif
                                            @else
                                                <span class="text">{{ __('Details Not Available') }}</span>
                                    @endif
                            </div>
                        </div>
                        <div class="product-quantity">
                            <form>
                                <div class="quantity">
                                    <input type="button" value="-" class="minus">
                                    <input type="number" class="input-number" min="1" name="quantity" value="1">
                                    <input type="button" value="+" class="plus">
                                </div>
                            </form>
                        </div>
                        @if($product->sizes->count() > 0)
                            <div class="product-size-wrap">
                                <h6>{{ __('Size') }} :</h6>
                                <ul>
                                    @foreach($product->sizes as $size)
                                        <li>
                                            <label class="product-size">
                                                <input type="radio" checked="checked" name="size" value="{{ $size->name }}">
                                                <span class="checkmark">{{ $size->name }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if($product->colors)
                            <div class="product-color-wraper">
                                <h6>{{ __('Color') }} :</h6>
                                <ul>
                                    @foreach($product->colors as $color)
                                        <li>
                                            <label class="porduct-color">
                                                <input type="radio" name="color" value="{{ $color->name }}">
                                                <span class="checkmark" style="background-color: {{ $color->hex }}"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="product-link">
                            <ul>
                                <li><a href="javascript:addToCart({{$product->id}})" class="link-anime add-to-card">{{ __('Add to CartItem')}}</a></li>
                                <li><a href="javascript:buyNow({{$product->id}})" class="link-anime">{{ __('Buy Now') }}</a></li>
                                <li><a href="javascript:addToWishlist({{ $product->id }})" class="link-anime">{{ __('Add to Favorite') }}</a></li>
                            </ul>
                        </div>
                        <div class="product-share">
                            <ul>
                                <li>
                                    <div data-href="{{ url()->full() }}" data-layout="button" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->full()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7.611 15.612"><path d="M182.157,756.25v-1.366c0-.683.1-1.073,1.171-1.073h1.366v-2.634H182.45c-2.732,0-3.61,1.268-3.61,3.513v1.659h-1.756v2.634h1.659v7.806h3.415v-7.806H184.4l.293-2.732Z" transform="translate(-177.083 -751.176)"></path></svg></a></div>
                                </li>
                                <li>
                                    <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{url()->full()}}" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.438 12.506"><path d="M260.322,753.734a6.3,6.3,0,0,1-1.922.481,3.152,3.152,0,0,0,1.442-1.73,7.937,7.937,0,0,1-2.115.769,3.649,3.649,0,0,0-2.5-.961,3.308,3.308,0,0,0-3.364,3.172,1.436,1.436,0,0,0,.1.673,9.507,9.507,0,0,1-6.921-3.268,2.987,2.987,0,0,0-.481,1.634,3.033,3.033,0,0,0,1.538,2.6,4.036,4.036,0,0,1-1.538-.384h0a3.183,3.183,0,0,0,2.691,3.076,2.676,2.676,0,0,1-.865.1,1.883,1.883,0,0,1-.673-.1A3.269,3.269,0,0,0,248.883,762a6.949,6.949,0,0,1-4.23,1.346h-.769a10.5,10.5,0,0,0,5.191,1.442,9.2,9.2,0,0,0,9.607-8.769c0-.057,0-.113.006-.17v-.385A9.388,9.388,0,0,0,260.322,753.734Z" transform="translate(-243.884 -752.292)"></path></svg></a>
                                </li>

                                <li>
                                    <a href="https://www.pinterest.com/pin/create/button?url={{ route('product',$product->slug) }}&media={{ asset('uploads/products/galleries') }}/{{ $product->images->first()->image }}&description={{ $product->name }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.802 13.892"><path d="M468.8,905.325a3.953,3.953,0,0,1-1.816-.865c-.346,1.9-.778,3.719-2.162,4.671-.432-2.854.605-5.017,1.038-7.352-.779-1.3.086-3.979,1.73-3.374,2.076.779-1.816,4.93.779,5.449,2.681.519,3.806-4.671,2.162-6.4-2.422-2.422-7.006-.087-6.487,3.46.173.865,1.038,1.125.346,2.336-1.557-.346-1.99-1.557-1.9-3.2a5.178,5.178,0,0,1,4.671-4.757c2.941-.346,5.622,1.038,6.055,3.806.433,3.114-1.3,6.487-4.411,6.228Z" transform="translate(-462.474 -895.239)"></path></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('product',$product->slug) }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z"/></svg>
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="modal" href="#shareModal" role="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M406,332c-29.636,0-55.969,14.402-72.378,36.571l-141.27-72.195C194.722,288.324,196,279.809,196,271
                                        c0-11.931-2.339-23.324-6.574-33.753l148.06-88.958C354.006,167.679,378.59,180,406,180c49.626,0,90-40.374,90-90
                                        c0-49.626-40.374-90-90-90c-49.626,0-90,40.374-90,90c0,11.47,2.161,22.443,6.09,32.54l-148.43,89.18
                                        C157.152,192.902,132.941,181,106,181c-49.626,0-90,40.374-90,90c0,49.626,40.374,90,90,90c30.122,0,56.832-14.876,73.177-37.666
                                        l140.86,71.985C317.414,403.753,316,412.714,316,422c0,49.626,40.374,90,90,90c49.626,0,90-40.374,90-90
                                        C496,372.374,455.626,332,406,332z M406,30c33.084,0,60,26.916,60,60s-26.916,60-60,60s-60-26.916-60-60S372.916,30,406,30z
                                        M106,331c-33.084,0-60-26.916-60-60s26.916-60,60-60s60,26.916,60,60S139.084,331,106,331z M406,482c-33.084,0-60-26.916-60-60
                                        s26.916-60,60-60s60,26.916,60,60S439.084,482,406,482z"></path></svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row tab-info">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">{{ __('Description') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">{{ __('Specifications') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false"> {{ __('Reviews') }} ({{ $product->reviews->count() }})</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            {!! $product->description ?? 'No Description Available' !!}
                        </div>
                        <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                            @if($product->specification)
                                <a href="{{ asset('uploads/products/pdf') }}/{{ $product->pdf_specification }}" class="text-primary" target="_blank">{{ __('Click here to download product specification in PDF format') }}</a>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            @if($product->reviews->count() == 0)
                                <p class="woocommerce-noreviews">{{ __('There are no reviews yet.') }}</p>
                            @endif

                            @foreach($product->reviews as $review)
                                <b>{{ $review->user->first_name }}</b>
                                <div class="rateit" data-rateit-value="{{ $review->review_point }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                <p>{{ $review->review_note }}</p>
                                <hr>
                            @endforeach
                            @if(auth('customer')->check())
                                @if(canReview(auth('customer')->id(),$product->id))
                                    <form class="contact-form" action="{{ route('customer.review') }}" method="post">
                                        @csrf
                                        <div class="mb-2">
                                            <!-- Product Rating -->
                                            <input type="range" name="review_point" value="5" step="1" id="backing5">
                                            <div class="rateit" data-rateit-backingfld="#backing5" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                                            </div>
                                            <!-- /Product Rating -->
                                        </div>

                                        <div class="row">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <textarea class="form-control" name="review_note"></textarea>
                                                    <span class="label">{{ __('Your review') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn-anime">{{ __('Submit') }}</button>
                                    </form>
                                @else
                                    <p>{{ __('You are not eligible to review this product') }}</p>
                                @endif
                            @else
                                <p>{{ __('Login to review this product') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details End -->
    <!-- Similar Product Start -->
    <section class="similar-product">
        <div class="container">
            <div class="title-center">
                <h4>{{ __('Similar Products') }}</h4>
                <p>{{ __('The Standard chunk of lorem ipsum reproduced below those interested.') }}</p>
            </div>
            <div class="row auto-margin-3">
                @foreach($similarProducts as $similar)
                    <div class="col-sm-6 col-lg">
                        <x-frontend.product-card :product="$similar"></x-frontend.product-card>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Similar Product End -->

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <pre>{{ __('Copy the link below and paste on you site') }}</pre>
                    <p class="text-danger" id="myInput">{{ route('product',$product->slug) }}</p>
                    <button class="btn-anime badge badge-dark" data-bs-dismiss="modal" aria-label="Close" onclick="navigator.clipboard.writeText('{{ route('product',$product->slug) }}')">{{ __('copy') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop
