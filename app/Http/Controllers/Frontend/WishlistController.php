<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Product;
use App\Models\Frontend\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index()
    {
        $wishlists = Wishlist::query()
            ->where('user_id',auth('customer')->id())
            ->get();

        return view('frontend.pages.wishlist',compact('wishlists'));
    }

    public function store(Request $request)
    {
        if(!auth('customer')->check()){
            return redirect()->route('customer.login');
        }

        $data = [
            'user_id' => auth('customer')->id(),
            'product_id' => $request->get('id'),
            'created_by' => auth('customer')->id(),
        ];

        $wish = Wishlist::query()->create($data);

        $name = $wish->product->name;
        $count = Wishlist::query()->where('user_id',auth('customer')->id())->count();

        return response(['status'=>'success','count'=>$count,'name'=>$name]);
    }

    public function wishToCart(Request $request)
    {
        $id = $request->get('id');
        $wishlist = Wishlist::query()->findOrFail($id);
        $product = Product::query()->findOrFail($wishlist->product_id);

        $cart = json_decode(Cookie::get('cart',''),true);

        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['total'] = $cart[$product->id]['price'] * $cart[$product->id]['quantity'];
            $cart[$product->id]['shipping_cost'] = $cart[$product->id]['shipping_cost'] * $cart[$product->id]['quantity'];
        }else{
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => 1,
                'price' => $this->price($wishlist->product_id),
                'color' => $request->get('color'),
                'size' => $request->get('size'),
                'shipping_cost' => $product->details->is_free_shipping == 0 ? $product->shipping_cost : 0,
                'total_shipping_cost' => ($product->details->is_free_shipping == 0 ? $product->shipping_cost : 0),
                'estimated_shipping_days' => $product->details->estimated_shipping_days ?? '3 to 7 days',
                'image' => $product->images()->first()->image ?? 'default.png',
                'product_total' => $this->price($product->id),
                'total' => ($product->details->is_free_shipping == 0 ? $product->shipping_cost : 0) + $this->price($wishlist->product_id),
            ];
        }

        Cookie::queue(Cookie::make('cart',json_encode($cart),config('constants.cart_expire_min')));

        // calculate subtotal for an item
        $subTotal = 0;
        $totalShipping = 0;
        foreach($cart as $item){
            $subTotal += $item['total'];
            $totalShipping += $item['total_shipping_cost'];
        }

        $total = $subTotal + $totalShipping;

        Cookie::queue(Cookie::make('subTotal',$subTotal));
        Cookie::queue(Cookie::make('totalShipping',$totalShipping));
        Cookie::queue(Cookie::make('total',$total));

        $count = count($cart); //count cart items

        /** remove from wishlist if exists */
        $wishlist->delete();

        $wishCount = Wishlist::query()->where('user_id',auth('customer')->id())->count();

        return response(['status'=>'success','count'=>$count,'wishCount'=>$wishCount,'name'=>$product->name]);
    }

    public function removeFromWishlist(Request $request)
    {
        $id = $request->get('id');
        $wish = Wishlist::query()->findOrFail($id);
        $wish->delete();
        $count = Wishlist::query()->where('user_id',auth('customer')->id())->count();
        return response(['status'=>'success','count'=>$count,'name'=>$wish->product->name]);
    }

    public function price($product)
    {
        $product = Product::query()->findOrFail($product);
        if($product->promotions->count() > 0){
            $price = $product->promotion_price;
        }else{
            $price = ($product->unit_price - $product->discount);
        }

        return $price;
    }
}
