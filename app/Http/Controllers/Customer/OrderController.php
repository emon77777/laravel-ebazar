<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Frontend\OrderDetail;
use App\Models\Frontend\Order;
use App\Models\Frontend\OrderTimeline;
use App\Models\Frontend\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Display order list
     *
     * @return View
     */
    public function index(): View
    {
        $orders = OrderDetail::query()
            ->where('user_id',auth()->id())
            ->paginate(10);

        $stat = 0;

        return view('customer.pages.order',compact('orders','stat'));
    }

    public function invoice($id)
    {
        $order = Order::query()->findOrFail($id);

        if(Gate::denies('access',$order)){
            abort(401);
        }

        $customer = $order->customer;

        return view('customer.pages.invoice',compact('order','customer'));
    }

    /**
     * Display an ordered item details
     *
     * @param $id
     * @return View
     */
    public function details($id): View
    {
        $order = OrderDetail::query()->findOrFail($id);

        if(Gate::denies('access',$order)){
            abort(401);
        }

        return view('customer.pages.order-details',compact('order'));
    }

    /**
     * Display the order cancel page
     *
     * @param $id
     * @return View
     */
    public function orderCancel($id): View
    {
        $order = OrderDetail::query()->findOrFail($id);

        if(Gate::denies('access',$order)){
            abort(401);
        }

        $cancellationPolicy = Page::query()->where('menu_id',17)->first();

        return view('customer.pages.order-cancel',compact('order','cancellationPolicy'));
    }

    /**
     * Display an order list in customer dashboard
     *
     * @param Request $request
     * @return View
     */
    public function list(Request $request): View
    {
        $order = OrderDetail::query()->where('user_id',auth('customer')->id());

        if($request->has('stat')){
            $stat = $request->get('stat');
            if($stat > 0){
                $order->where('order_stat',$stat);
            }
        }else{
            $stat = 0;
        }

        if($request->has('search')){
            $search = $request->get('search');
            $order->where('order_no','like','%'.$search.'%');
        }

        $orders = $order->latest()->paginate(10);

        return view('customer.pages._order_list',compact('orders','stat'));
    }

    public function cancel(Request $request, $id)
    {
        $is_confirm = $request->get('confirm');

        if(!$is_confirm){
            return redirect()->back();
        }

        $order = OrderDetail::query()->findOrFail($id);

        if(Gate::denies('access',$order)){
            abort(401);
        }

        $data = [
            'order_detail_id' => $id,
            'user_id' => auth('customer')->id(),
            'product_id' => $order->product_id,
            'order_stat' => 7,
            'order_stat_desc' => $request->order_stat_desc,
            'order_stat_datetime' => now(),
            'remarks' => $request->remarks,
        ];

        OrderTimeline::query()->create($data);

        $order->update(['order_stat'=>7]);

        return redirect('order');
    }
}
