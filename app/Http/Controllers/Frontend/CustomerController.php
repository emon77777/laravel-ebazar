<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Country;
use App\Models\Frontend\OrderDetail;
use App\Models\Frontend\ShippingAddress;
use App\Models\Frontend\User;
use App\Models\Frontend\UserBilling;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index()
    {
        $url = config('constants.image_base_path').'/orders.json';

        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // Set the url
        curl_setopt($ch,CURLOPT_URL,$url);
        // Execute
        $result = curl_exec($ch);
        // Closing
        curl_close($ch);

        $allOrders = json_decode($result,true);
        $pending = json_decode($result,true);
        return view('customer.pages.order',compact('allOrders','pending'));
    }

    public function profile()
    {
        $user = auth('customer')->user();
        $orders = OrderDetail::query()->where('user_id',auth('customer')->id())->get();
        $shipping = ShippingAddress::query()->where('user_id',auth('customer')->id())->latest()->first();
        $billing = UserBilling::query()->where('user_id',auth('customer')->id())->latest()->first();

        $countries = Country::query()->where('is_active',1)->get();

        if ($billing == null){
            $billing = new UserBilling;
        }

        if($shipping == null){
            $shipping = new ShippingAddress;
        }

        return view('customer.pages.profile',compact('user','orders','billing','shipping','countries'));
    }

    /**
     * Update user's information
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|numeric',
            'dob' => 'required|date',
            'gender' => 'required'
        ]);

        $user = User::query()->findOrFail($id);
        $user->update($request->all());

        Session::flash('success','Profile has been updated');

        return redirect()->back();
    }

    /**
     * Update user's default billing information
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function billing(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'address_1' => 'required',
            'user_city' => 'required',
            'mobile' => 'required|numeric',
            'post_code' => 'required|max:5',
        ]);

        $request['user_id'] = auth('customer')->id();

        $billing = auth('customer')->user()->billing;

        if($billing){
            $billing->update($request->all());
        }else{
            UserBilling::query()->create($request->all());
        }

        if($request->has('address')){
            $user = auth('customer')->user();
            $user->update(['address'=>$request->get('address')]);
        }

        Session::flash('success','Billing has been updated');

        return redirect()->back();
    }

    /**
     * Update user's default shipping address
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function shipping(Request $request): RedirectResponse
    {
        $this->validate($request,[
            "address_line_one" => 'required',
            "address_line_two" => 'required',
            "shipping_post" => 'required',
            "shipping_town" => 'required',
            "shipping_country_id" => 'required',
        ]);

        $request['user_id'] = auth('customer')->id();

        $shipping = auth('customer')->user()->shipping;

        if($shipping){
            $shipping->update($request->all());
        }else{
            ShippingAddress::query()->create($request->all());
        }

        Session::flash('success','Shipping address has been updated');

        return redirect()->back();
    }

    /**
     * Update user's avatar
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function image(Request $request, $id): RedirectResponse
    {
        $this->validate($request,[
            'image' => 'required'
        ]);

        $image = now()->format('YmdHis').$id.'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->move(public_path('frontend/img/users'), $image);
        $data['image'] = $image;

        $user = User::query()->findOrFail($id);

        $oldImage = $user->image;

        $user->update($data);

        File::delete(public_path('frontend/img/users/').$oldImage);

        return redirect()->back();

    }

    public function changePassword(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::query()->find(auth('customer')->id());

        if(Hash::check($request->old_password,$user->password)){
            $user->update(['password'=>bcrypt($request->password)]);
        }else{
            Session::flash('error','Password not matched');
        }

        return redirect()->back();
    }

}
