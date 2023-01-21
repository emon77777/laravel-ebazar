<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function store(Request $request)
    {
        $user = auth('customer')->id();
        $address = ShippingAddress::query()->where('user_id',$user)->latest()->first();

        if(!$address){
            $data = [
                "user_id" => auth('customer')->id(),
                "shipping_name" => $request->shipping_name,
                "address_line_one" => $request->address_line_one,
                "address_line_two" => $request->address_line_two,
                "shipping_post" => $request->shipping_post,
                "shipping_town" => $request->shipping_town,
                "shipping_country_id" => $request->shipping_country_id,
                "shipping_note" => $request->shipping_note
            ];

            ShippingAddress::query()->create($data);
        }
    }
}
