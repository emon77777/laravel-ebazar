<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Frontend\ProductReview;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ProductReviewController extends Controller
{
    use ApiResponse, ResponseMessage;

    /**
     * Store customer review in storage
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(Request $request,$id): JsonResponse
    {
            $product_reviews = ProductReview::query()->where('product_id',$id)->paginate(20);

            return $this->successResponse($product_reviews, $this->load_success['message'], Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'product_id' => 'required',
            'review_point' => 'required',
            'review_note' => 'required'
        ]);
        try {
            $request['user_id'] = auth('api')->id();
            $email = auth('api')->user()->email;

            $product_review = ProductReview::query()->create($request->all());

            if ($email) {
                Mail::to($email)->send(new \App\Mail\ProductReview($request->all()));
            }

            return $this->successResponse($product_review, $this->create_success_message['message'], Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage());
        }
    }
}
