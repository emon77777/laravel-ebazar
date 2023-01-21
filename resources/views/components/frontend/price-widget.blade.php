<div class="sidebar-widget">
    <h6>{{ __('Price') }}</h6>
    <div class="price-range-wraper">
        <div class="a"></div>
        <div class="price-wrap">
            <p>{{ __('Price') }}:</p>
            <div class="price-input-wrapper">
                <span class="first">{{ userCurrency('symbol') }}</span>
                <input class="b price-check" id="price-check-b" type="text" readonly>
                <span class="middle">{{ __(' - ') }}</span>
                <span class="last">{{ userCurrency('symbol') }}</span>
                <input class="c price-check" id="price-check-c" type="text" readonly>
            </div>
        </div>
    </div>
</div>
