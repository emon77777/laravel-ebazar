<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\CartItem;
use App\Models\Frontend\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    /**
     * Add product to cart by ajax
     *
     * @param Request $request
     * @return Response
     */
    public function addToCart(Request $request): Response
    {
        $id = $request->get('id');
        $quantity = $request->get('qty');
        $product = Product::query()->findOrFail($id);
        $cart = json_decode(Cookie::get('cart',''),true);

//        if(isset($cart[$id])){
//            $cart[$id]['quantity']++;
//            $cart[$id]['total'] = $cart[$id]['price'] * $cart[$id]['quantity'];
//            $cart[$id]['shipping_cost'] = $cart[$id]['shipping_cost'] * $cart[$id]['quantity'];
//        }else{
            $quantity = is_numeric($quantity) ? $quantity : 1;
            $cart[$id.rand(10000,99999)] = [
                'id' => $product->id,
                //'name' => $product->name,
                'quantity' => $quantity,
                'currency_id' => userCurrency('id'),
                //'price' => $this->price($product->id),
                'color' => $request->get('color'),
                'size' => $request->get('size'),
                //'shipping_cost' => $this->shipping($product->id),
                //'total_shipping_cost' => $this->shipping($product->id,$quantity),
                //'estimated_shipping_days' => $product->details->estimated_shipping_days ?? '3 to 7 days',
                //'image' => $product->images()->first()->image ?? 'default.png',
                //'product_total' => $this->price($product->id) * $quantity,
                'total' => CartItem::shipping($id,$quantity) + CartItem::price($id,$quantity),
            ];
//        }

        Cookie::queue(Cookie::make('cart',json_encode($cart),120));

        $subTotal = 0;
        $totalShipping = 0;
        foreach($cart as $item){
            $subTotal += CartItem::price($item['id'],$item['quantity']);
            $totalShipping += CartItem::shipping($item['id'],$item['quantity']);
        }

        $total = $subTotal + $totalShipping;

        Cookie::queue(Cookie::make('subTotal',$subTotal));
        Cookie::queue(Cookie::make('totalShipping',$totalShipping));
        Cookie::queue(Cookie::make('total',$total));

        $count = count($cart); //count cart items

        return response(['status'=>'success','count'=>$count,'name'=>$product->name]);
    }

    /**
     * Update CartItem by ajax
     *
     * @param Request $request
     * @return Response
     */
    public function updateCart(Request $request): Response
    {
        $key = $request->get('key');
        $id = $request->get('id');
        $product = Product::query()->findOrFail($id);
        $cart = json_decode(Cookie::get('cart'),true);

        $cart[$key] = [
            'id' => $id,
            //'name' => CartItem::name($id),
            'quantity' => $request->get('qty'),
            'currency_id' => userCurrency('id'),
            //'price' => CartItem::price($id),
            'color' => $request->get('color'),
            'size' => $request->get('size'),
            //'shipping_cost' => CartItem::shipping($id),
            //'total_shipping_cost' => CartItem::shipping($id,$request->get('qty')),
            //'estimated_shipping_days' => CartItem::estimatedShippingDays($id),
            //'image' => $product->images()->first()->image ?? 'default.png',
            //'product_total' => $this->price($product->id) * $request->get('qty'),
            'total' => CartItem::shipping($id,$request->get('quantity')) + CartItem::price($id,$request->get('quantity')),
        ];

        Cookie::queue(Cookie::make('cart',json_encode($cart),120));

        $subTotal = 0;
        $totalShipping = 0;
        foreach($cart as $item){
            $subTotal += CartItem::price($item['id'],$item['quantity']);
            $totalShipping += CartItem::shipping($item['id'],$request->get('qty'));
        }

        $productTotal = CartItem::price($id,$request->get('qty'));
        $total = $subTotal + $totalShipping;

        Cookie::queue(Cookie::make('subTotal',$subTotal,120));
        Cookie::queue(Cookie::make('totalShipping',$totalShipping,120));
        Cookie::queue(Cookie::make('total',$total,120));

        return response([
            'status' => 'success',
            'productTotal' => currency($productTotal,2),
            'subTotal' => currency($subTotal,2)
        ]);
    }

    /**
     * Remove item form cart by ajax
     *
     * @param Request $request
     * @return Response
     */
    public function removeFromCart(Request $request): Response
    {
        $key = $request->get('key');
        $id = $request->get('id');

        $cart = json_decode(Cookie::get('cart'),true);
        unset($cart[$key]);
        if(empty($cart)){
            Cookie::queue(Cookie::forget('cart'));
        }else{
            Cookie::queue(Cookie::make('cart',json_encode($cart),120));
        }

        $count = count($cart);
        $product = Product::query()->findOrFail($id);

        $subTotal = 0;
        $totalShipping = 0;
        foreach($cart as $item){
            $subTotal += CartItem::price($item['id'],$item['quantity']);
            $totalShipping += CartItem::shipping($item['id'],$item['quantity']);
        }

        Cookie::queue(Cookie::make('subTotal',$subTotal,120));
        Cookie::queue(Cookie::make('totalShipping',120));

        return response(['status'=>'success','count'=>$count,'name'=>$product->name,'subTotal'=>$subTotal,'totalShipping'=>$totalShipping,'carts'=>$cart]);
    }

//    public function price($id)
//    {
//        $product = Product::query()->findOrFail($id);
//        if(hasPromotion($id)){
//            $price = promotionPrice($id);
//        }else{
//            $price = ($product->unit_price - $product->discount);
//        }
//
//        return $price;
//    }

//    public function shipping($id, $quantity = 1)
//    {
//        $product = Product::query()->findOrFail($id);
//
//        if($product->details->is_free_shipping == 0){
//            $value = ($product->shipping_cost * $quantity);
//        }else{
//            $value = 0;
//        }
//
//        return $value;
//    }
}
