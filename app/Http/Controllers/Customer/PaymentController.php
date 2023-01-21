<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\ShippingAddressController;
use App\Http\Controllers\Frontend\UserBillingInfoController;
use App\Mail\OrderPending;
use App\Models\Frontend\CartItem;
use App\Models\Frontend\Currency;
use App\Models\Frontend\Order;
use App\Models\Frontend\OrderDetail;
use App\Models\Frontend\OrderPayment;
use App\Models\Frontend\OrderTimeline;
use App\Models\Frontend\PaymentGateway;
use App\Models\Frontend\PayPalClient;
use App\Models\Frontend\Product;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Stripe\Customer;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\RateLimitException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'address_1' => 'required|max:100',
            'mobile' => 'required|numeric',
            'shipping_name' => 'required',
            'address_line_one' => 'required',
            'address_line_two' => 'sometimes|max:255',
            'shipping_note' => 'sometimes|max:255'
        ]);

        app(ShippingAddressController::class)->store($request);

        $shipping = $request->except(['_token']);
        Cookie::queue(Cookie::make('shipping',json_encode($shipping),120));

        app(UserBillingInfoController::class)->store($request);

        if($request->get('paymentOption') == 1){
            return view('customer.checkout.stripe');
        }elseif($request->get('paymentOption') == 2){
            $payment = PaymentGateway::query()->where('name','razorpay')->first();
            $configurations = json_decode($payment->configuration);
            return view('customer.checkout.razorpay',compact('configurations'));
        }elseif($request->get('paymentOption') == 3){
            $payment = PaymentGateway::query()->where('name','paypal')->first();
            $configurations = json_decode($payment->configuration);

            return view('customer.checkout.paypal',compact('configurations'));
        }

        $request['order_stat_desc'] = 'Order placed via cash on delivery';
        $request['payment_by'] = 'cod';
        $order = $this->orderStore($request,json_encode($shipping));

        $cart = json_decode(Cookie::get('cart'));
        $subTotal = Cookie::get('subTotal');
        $totalShipping = Cookie::get('totalShipping');
        $total = Cookie::get('total');

        session()->put('order',$order);
        session()->put('items',$cart);
        session()->put('subTotal',$subTotal);

        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('subTotal'));
        Cookie::queue(Cookie::forget('totalShipping'));
        Cookie::queue(Cookie::forget('total'));
        $similarProducts = Product::query()->inRandomOrder()->take(5)->get();

        return view('customer.checkout.payment-success',compact('similarProducts','order','cart','subTotal','totalShipping','total'));
    }

    /**
     * Checkout with stripe
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ApiErrorException
     * @throws ValidationException
     */
    public function stripe(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'card_number' => 'required|digits_between:16,20',
            'month' => 'numeric|max:12',
            'year' => 'numeric|digits:4|min:2021',
            'cvc' => 'numeric|digits:3'
        ]);

        $cart = json_decode(Cookie::get('cart'));
        $subTotal = Cookie::get('subTotal');
        $shipping = json_decode(Cookie::get('shipping'));
        $currency = json_decode(Cookie::get('currency'),true);
        $totalShipping = Cookie::get('totalShipping');
        $total = Cookie::get('total');

        $cc = $currency ? $currency['cc'] : 'usd';
        $amount = $currency ? $shipping->subTotal * $currency['exchange_rate'] : $shipping->subTotal;

        $payment = PaymentGateway::query()->where('name','stripe')->first();
        $configurations = json_decode($payment->configuration);

        Stripe::setApiKey($configurations->SECRET);

        try {
            $p = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->month,
                    'exp_year' => $request->year,
                    'cvc' => $request->cvc,
                ],
            ]);
        } catch(CardException|RateLimitException|InvalidRequestException|AuthenticationException|ApiConnectionException|ApiErrorException $e) {
            return redirect('checkout')->withErrors(['payment'=>$e->getError()->message]);
        } catch (Exception $e) {
            return redirect('checkout')->withErrors(['payment'=>$e->getError()->message]);
        }

        PaymentIntent::create([
            'description' => 'Software development services',
            'shipping' => [
                'name' => $shipping->first_name.' '.$shipping->last_name,
                'address' => [
                    'line1' => $shipping->address_1,
                    'postal_code' => $shipping->post_code,
                    'city' => $shipping->city,
                    'state' => null,
                    'country' => 'Bangladesh',
                ],
            ],
            'payment_method' => $p->id,
            'confirm' => true,
            'amount' => $amount*100,
            'currency' => $cc,
            'payment_method_types' => ['card'],
        ]);

        Customer::create([
            'name' => auth('customer')->user()->first_name.' '.auth('customer')->user()->last_name,
            'address' => [
                'line1' => $shipping->address_1,
                'postal_code' => $shipping->post_code,
                'city' => $shipping->city,
                'state' => null,
                'country' => 'Bangladesh',
            ],
        ]);

        // store data in order info table
        $request['payment_by'] = 'stripe';
        $request['order_stat_desc'] = 'Order placed and confirmed via stripe';
        $order = $this->orderStore($request);

        // store data in payment table
        $data = [
            'order_id' => $order->id,
            'payment_type' => 1,
            'card_no' => $request->card_number,
            'card_name' => 1,
            'tax' => 0,
            'currency' => $cc,
            'exchange_rate' => $currency ? $currency['exchange_rate'] : 1,
            'created_by' => auth('customer')->id(),
            'updated_by' => auth('customer')->id()
        ];

        OrderPayment::query()->create($data);

        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('subTotal'));

        return redirect()->route('customer.payment-success')->with(['order'=>$order,'items'=>$cart,'subTotal'=>$subTotal]);
    }

    /**
     * Checkout with PayPal
     *
     * @param false $debug
     * @return Response
     */
    public function paypal(bool $debug = false): Response
    {
        $request = new OrdersCreateRequest();
        $request->prefer("return=representation");
        $request->body = $this->buildRequestBody();

        $client = PayPalClient::client();
        $response = $client->execute($request);

        if ($debug){
            print "Status Code: {$response->statusCode}\n";
            print "Status: {$response->result->status}\n";
            print "Order ID: {$response->result->id}\n";
            print "Intent: {$response->result->intent}\n";
            print "Links:\n";
            foreach($response->result->links as $link){
                print "\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n";
            }
            // To print the whole response body, uncomment the following line
            // echo json_encode($response->result, JSON_PRETTY_PRINT);
        }

        // 4. Return a successful response to the client.
        return response([$response]);
    }

    public function paypalOrder()
    {
        // store data in order info table
        $data = new Request();
        $data['payment_by'] = 'paypal';
        $data['order_stat_desc'] = 'Order placed and confirmed via paypal';
        $order = $this->orderStore($data);

        $cart = json_decode(Cookie::get('cart'));
        $subTotal = Cookie::get('subTotal');

        session()->put('order',$order);
        session()->put('items',$cart);
        session()->put('subTotal',$subTotal);

        // Clear the cart information from cookies
        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('shipping'));
        Cookie::queue(Cookie::forget('subTotal'));
    }

    /**
     * Build a PayPal order create request body
     *
     * @return array
     */
    public function buildRequestBody(): array
    {
        $currency = Cookie::has('currency') ? json_decode(Cookie::get('currency'),true) : ['cc'=>'usd','exchange_rate'=>1];

        return [
            'intent' => 'CAPTURE',
            'application_context' =>
                [
                    'return_url' => route('customer.payment-success'),
                    'cancel_url' => route('customer.payment-cancel')
                ],
            'purchase_units' =>
                [
                    0 =>
                        [
                            'amount' =>
                                [
                                    'currency_code' => $currency['cc'],
                                    'value' => Cookie::get('subTotal') * $currency['exchange_rate'],
                                ]
                        ]
                ]
        ];
    }

    public function razorpay(Request $request)
    {
        $data = new Request();
        $data['order_stat_desc'] = $request['razorpay_payment_id'];
        $data['payment_by'] = 'razorpay';
        $data['razorpay_payment_id'] = $request['razorpay_payment_id'];

        $order = $this->orderStore($data);

        $cart = json_decode(Cookie::get('cart'));
        $subTotal = Cookie::get('subTotal');

        session()->put('order',$order);
        session()->put('items',$cart);
        session()->put('subTotal',$subTotal);

        // Clear the cart information from cookies
        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('shipping'));
        Cookie::queue(Cookie::forget('subTotal'));

        $cart = json_decode(Cookie::get('cart'));
        $subTotal = Cookie::get('subTotal');
        $totalShipping = Cookie::get('totalShipping');
        $total = Cookie::get('total');

        $similarProducts = Product::query()->inRandomOrder()->take(5)->get();

        return view('customer.checkout.payment-success',compact('similarProducts','order','cart','subTotal','totalShipping','total'));
    }

    public function orderStore(Request $request,$shipping = null)
    {
        $cart = json_decode(Cookie::get('cart'));

        if(!$shipping){
            $shipping = json_decode(Cookie::get('shipping'));
        }else{
            $shipping = json_decode($shipping);
        }

        if($shipping == null){
            abort(419);
        }

        if(Cookie::has('currency')){
            $currency = json_decode(Cookie::get('currency'));
        }else{
            $currency = Currency::query()->findOrFail(maanAppearance('currency_id'));
        }

        $name = auth('customer')->user()->first_name;

        $order_no = Order::all()->last()->order_no ?? 1000;
        $order_no = substr($order_no,3);
        $order_no = 'INV'.($order_no + 1);
        $subTotal = Cookie::get('subTotal');

        if($request->get('email') != null){
            try {
                Mail::to(auth('customer')->user()->email)->send(new OrderPending(['request'=>$request,'name'=>$name,'order_no'=>$order_no,'subTotal'=>$subTotal,'cart'=>$cart]));
            }catch (\Swift_TransportException $e){
                Session::flash('error',$e->getMessage());
            }
        }

        /** store product details in database */
        $data = [
            'order_no'=> $order_no,
            'discount'=> null,
            'tax'=> null,
            'shipping_cost' => Cookie::get('totalShipping'),
            'total_price'=> Cookie::get('subTotal'),
            'currency_id'=> $currency->id,
            'exchange_rate'=> $currency->exchange_rate,
            'shipping_name'=> $shipping->shipping_name,
            'shipping_address_1'=> $shipping->address_line_one,
            'shipping_address_2'=> $shipping->address_line_two,
            'shipping_mobile' => $shipping->shipping_mobile,
            'shipping_email' => $shipping->shipping_email,
            'shipping_post' => $shipping->shipping_post,
            'shipping_town' => $shipping->shipping_town,
            'shipping_country_id' => $shipping->shipping_country_id,
            'shipping_note' => $shipping->note,
            'payment_by'=> $request->get('payment_by'),
            'user_id'=> auth('customer')->id(),
            'user_first_name'=> $shipping->first_name,
            'user_last_name'=> $shipping->last_name,
            'user_address_1'=> $shipping->address_1,
            'user_post_code'=> $shipping->post_code,
            'user_city'=> $shipping->city,
            'user_country_id' => $shipping->country_id,
            'user_mobile'=> $shipping->mobile,
            'user_email'=> $shipping->email,
        ];

        $order = Order::query()->create($data);

        /** store product details in database */
        foreach($cart as $item){
            $product = Product::query()->findOrFail($item->id);
            $data = [
                'seller_id' => $product->seller_id ?? null,
                'user_id' => auth('customer')->id(),
                'order_id' => $order->id,
                'order_stat' => 2,
                'product_id' => $item->id,
                'sale_price' => CartItem::price($item->id),
                'qty' => $item->quantity,
                'color' => $item->color ?? null,
                'size' => $item->size ?? null,
                'discount' => 0,
                'tax' => 0,
                'shipping_cost' => CartItem::shipping($item->id),
                'total_shipping_cost' => CartItem::shipping($item->id,$item->quantity),
                'total_price' => CartItem::price($item->id,$item->quantity),
                'grand_total' => CartItem::price($item->id,$item->quantity) + CartItem::shipping($item->id,$item->quantity),
                'currency_id' => $currency->id,
                'exchange_rate' => $currency->exchange_rate,
                'estimated_shipping_days' => CartItem::estimatedShippingDays($item->id),
            ];

            $details = OrderDetail::query()->create($data);

            $timeline = [
                'order_detail_id' => $details->id,
                'order_stat' => 2,
                'order_stat_desc' => $request->get('order_stat_desc'),
                'order_stat_datetime' => now(),
                'user_id' => auth('customer')->id(),
                'remarks' => '',
                'product_id' => $item->id,
            ];

            OrderTimeline::query()->create($timeline);
        }

        Cookie::queue(Cookie::forget('shipping'));

        return $order;

    }

    /**
     * Display success message
     *
     * @return View
     */
    public function paymentSuccess(): View
    {
        $msg = trans('Thank you for your payment');
        return view('customer.checkout.payment-success',compact('msg'));
    }
}
