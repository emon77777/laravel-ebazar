<div class="customer-dashboard-table">
    <table class="table">
        <thead>
        <tr>
            <th>{{ __('Image') }}</th>
            <th>{{ __('Product') }}</th>
            <th>{{ __('Delivery Time') }}</th>
            <th>{{ __('Quantity') }}</th>
            <th>{{ __('Payment') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>
                    @if($order->product)
                        <img src="{{ asset('uploads/products/galleries') }}/{{ $order->product->images->first()->image }}" alt="{{ $order->product->name }}">
                    @endif
                </td>
                <td><b>{{ $order->order->order_no ?? '' }}</b> <small>{{ $order->product->name ?? '' }} </small></td>
                <td>{{ $order->product->details->estimated_shipping_days ?? '7-30 days' }}</td>
                <td>{{ $order->qty }}</td>
                <td>{{ $order->order->payment_by ?? '' }}</td>
                <td>
                    <a href="" class="{{ orderButtonClass($order->order_stat) }}">{{ orderStatus($order->order_stat) }}</a>
                </td>
                <td><a href="{{ route('order.details',$order->id) }}" class="manage-btn">{{ __('Manage Order') }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<x-customer.page-navigation :paginator="$orders" :stat="$stat"></x-customer.page-navigation>
