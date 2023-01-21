<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\ProductReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    /**
     * Store customer review in storage
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request['user_id'] = auth('customer')->id();
        $email = auth('customer')->user()->email;

        ProductReview::query()->create($request->all());

        if($email){
            Mail::to($email)->send(new \App\Mail\ProductReview($request->all()));
        }

        return redirect()->back();
    }
}
