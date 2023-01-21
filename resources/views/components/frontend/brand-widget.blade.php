<div class="sidebar-widget">
    <h6>{{ __('Brand') }}</h6>
    <div class="widget-valu">
        <ul>
            @foreach($brands as $brand)
                <li>
                    <input type="checkbox" id="{{ $brand->slug }}" class="brand-check" value="{{ $brand->id }}">
                    <label for="{{ $brand->slug }}">{{ $brand->name }} ({{ $brand->products->count() }})</label>
                </li>
            @endforeach
        </ul>
    </div>
</div>
