<!-- Banner Start -->
<section class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="side-mega-manu">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="swiper banner-slider">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            <div class="swiper-slide row align-items-center" data-background="{{ asset('uploads/banners') }}/{{ $banner->image }}">
                                <div class="col-lg-7">
                                    <div class="banner-content">
                                        <h2>{{ $banner->sub_title }}
                                        </h2>
                                        <p>{{ $banner->description }}</p>
                                        <a href="{{ route('category',$banner->category->slug) }}">{{ __('SHOP NOW >') }}</a>
                                        <span class="discount-tag">{{ $banner->offer_title }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="banner-add">
                    <ul>
                        @foreach($bannerAds as $promotion)
                            <li>
                                <div class="banner-add-wrapper">
                                    <a href="{{ route('product',$promotion->product->slug) }}" class="banner-add-thumb">
                                        <img src="{{ asset('uploads/products/galleries') }}/{{ $promotion->product->images->first()->image }}" alt="{{ $promotion->product->name }}">
                                    </a>
                                    <div class="banner-add-content">
                                        <a href="{{ route('product',$promotion->product->slug) }}"><span>{{ $promotion->product->name }}</span></a>
                                        <h5><a href="{{ route('product',$promotion->product->slug) }}">{{ $promotion->title }}</a></h5>
                                        <div class="star-rating">
                                            <div class="rateit" data-rateit-value="{{ productRating($promotion->product_id) }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner End -->

@push('script')
    <script>

        bannerSlider()

        /*======================
            Banner Slider
        ======================*/
        function bannerSlider() {
            "use strict";

            let menu = [
                @foreach($banners as $banner)
                    "{{ $banner->title }}",
                @endforeach
            ]
            let mySwiper = new Swiper(".banner-slider", {
                slidesPerView: 'auto',
                centeredSlides: true,
                spaceBetween: 0,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet: function(index, className) {
                        return '<div class="' + className + '">' + (menu[index]) + '</div>';
                    },
                },
            });

            $('.swiper-pagination-bullet').on('mouseover',function() {
                $(this).trigger("click");
            });
        }
    </script>
@endpush
