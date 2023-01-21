<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\UserBilling;
use Illuminate\Http\Request;

class UserBillingInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function store(Request $request)
    {
        $isExists = UserBilling::query()->where('user_id',auth('customer')->id())->exists();

        if(!$isExists){
            $request['user_id'] = auth('customer')->id();

            UserBilling::query()->create($request->all());
        }
    }
}
