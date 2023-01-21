<table class="table table-responsive-sm">
    <tbody>
    @foreach($new_orders as $key => $order)
        <tr>
            <td>
                <div
                    class="maan-appoint-image maan-radius d-flex align-items-center">
                    @if($order->product()->exists() && $order->product->images()->exists() && $order->product->images->first()->image)
                        <img class="mr-2"
                             src="{{URL::to('uploads/products/galleries/' . $order->product->images->first()->image??'')}}"
                             alt="productImage">
                    @else
                        <img class="mr-2"
                             src="{{URL::to('uploads/products/galleries/default.jpg')}}"
                             alt="productImage">
                    @endif
                    <div class="media-body">
                        <a href="{{auth('seller')->user() ? route('seller.orders.show', $order->order->id) : route('backend.orders.show', $order->order->id)}}">
                            <h5 class="mt-0 mb-1 maan-appoint-dg">{{$order->order->order_no??''}}</h5>
                        </a>
                        <p class="mb-0 maan-chart-title fs">{{$order->product->name??''}}</p>
                    </div>
                </div>
            </td>
            <td>
                <p class="maan-date mb-0">{{date("Y-m-d", strtotime($order->created_at))}}
                    <br>
                    {{date('H:i A',strtotime($order->created_at))}}</p>
            </td>
            <td>
                <div class="align-items-center">
                    <div class="maan-appoint-status maan-app-radius">
                        <span
                            class="maan-title maan-bg-warning-light text-capitalize">
                            {{$order->orderStatus->name?strtolower($order->orderStatus->name):''}}</span>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
