<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Backend\Country;
use App\Models\Frontend\FAQ;
use App\Models\Frontend\ShippingAddress;
use App\Models\Frontend\UserBilling;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Display checkout page
     *
     * @return View
     */
    public function checkout(): View
    {
        $cart = json_decode(Cookie::get('cart'),true);

        $billing = UserBilling::query()
            ->where('user_id',auth('customer')->id())
            ->where('is_active',1)
            ->orderByDesc('id')
            ->first();

        $shipping = ShippingAddress::query()
            ->where('user_id',auth('customer')->id())
            ->latest()
            ->first();

        $countries = Country::query()->where('is_active',1)->get();

        if($cart == null){
            return view('frontend.pages.cart');
        }

        return view('customer.checkout.checkout',compact('cart','billing','shipping','countries'));
    }

    /**
     * Display Announcement Page
     *
     * @return View
     */
    public function announcement(): View
    {
        return view('customer.pages.announcement');
    }

    /**
     * Display FAQ Page
     *
     * @return View
     */
    public function faq(): View
    {
        $faqs = FAQ::query()->where('is_active',1)->paginate(10);
        return view('customer.pages.faq',compact('faqs'));
    }
}
