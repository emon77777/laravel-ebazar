@if($offer)
    <section class="offer-count" data-background="{{ asset('uploads/promotions') }}/{{ $offer->image }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 offset-lg-7">
                    <div class="offer-text">
                        <h5>{{ $offer->title }}</h5>
                        <h2><span class="price">{{ $offer->label }}</span></h2>
                        <div class="offer-wrap">
                            <div class="countdown"></div>
                        </div>
                        <div class="offer-link">
                            <a class="link-anime" href="javascript:addToCart({{ $offer->product_id }})">{{ __('Shop Now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <script>
            countDown();
            function countDown() {
                $(".countdown").countdown({
                    year: {{ $offer->expire_at->format('Y') }},
                    month: {{ $offer->expire_at->format('m') }},
                    day: {{ $offer->expire_at->format('d') }},
                    hour: {{ $offer->expire_at->format('H') }},
                    minute: {{ $offer->expire_at->format('i') }},
                    second: {{ $offer->expire_at->format('s') }},
                });
            }
        </script>
    @endpush

@endif
