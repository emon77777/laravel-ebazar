<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Brand;
use App\Models\Frontend\Category;
use App\Models\Frontend\Color;
use App\Models\Frontend\Currency;
use App\Models\Frontend\EmailSubscriber;
use App\Models\Frontend\Menu;
use App\Models\Frontend\Product;
use App\Models\Frontend\Banner;
use App\Models\Frontend\ProductReview;
use App\Models\Frontend\Promotion;
use App\Models\Frontend\Seller;
use App\Models\Frontend\Size;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class FrontController extends Controller
{
    /**
     * Display landing page
     *
     * @return View
     */
    public function index(): View
    {
        $brands = Brand::query()
            ->active()
            ->orderBy('order')
            ->take(20)
            ->get();

        /** Category collection section */
        $categories = $this->categories();

        /** show product list by category */
        $shopCategories = Category::query()
            ->where('is_active',1)
            ->where('show_in_home',1)
            ->orderBy('order')
            ->get();

        /** Promotion Position One */
        $bannerAds = Promotion::query()
            ->eligible()
            ->where('position',1)
            ->orderByDesc('id')
            ->take(4)
            ->get();

        /** Promotion Position Two */
        $discounts = Promotion::query()
            ->eligible()
            ->where('position',2)
            ->orderByDesc('id')
            ->take(3)
            ->get();

        /** Promotion Position Three */
        $adPoster = Promotion::query()
            ->eligible()
            ->where('position',3)
            ->orderByDesc('id')
            ->first();

        /** Promotion Position Four */
        $offer = Promotion::query()
            ->eligible()
            ->where('position',4)
            ->orderByDesc('id')
            ->first();

        /** promotional slider contents queries */
        $banners = Banner::query()
            ->where('is_active',1)
            ->where('publish_stat',1)
            ->where(function($q){
                $q->where('expire_at','>',now())->orWhere('expire_at',null);
            })
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        /** "Deal of the day" product's query start */
        $allProducts = Product::query()
            ->where('is_active',1)
            ->inRandomOrder()
            ->take(5)
            ->get();

        $newArrivals = Product::query()
            ->where('is_active',1)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $bestSellers = Product::query()
            ->where('is_active',1)
            ->inRandomOrder()
            ->take(5)
            ->get();

        $featureProducts = Product::query()
            ->whereHas('details',function($q){
                $q->where('is_featured',1);
            })
            ->inRandomOrder()
            ->take(5)
            ->get();

        $trends = Product::query()
            ->inRandomOrder()
            ->take(5)
            ->get();
        /** Deal of the day product's query end */

        return view('frontend.index',compact('categories','shopCategories','allProducts','newArrivals','bestSellers','featureProducts','trends','brands','banners','adPoster','bannerAds','discounts','offer'));
    }

    public function shop()
    {
        $products = Product::query()
            ->paginate(24)
            ->withQueryString();

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active',1)
            ->where('is_suspended',0)
            ->has('products')
            ->get();

        $sizes = Size::query()->where('is_active',1)->get();

        $colors = Color::query()
            ->where('is_active',1)
            ->where('display_in_search',1)
            ->get();

        $prices = collect(['min'=>0,'max'=>5000,'values'=>[75,1000]]);

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        return view('frontend.pages.shop',compact('products','categories','sizes','colors','prices','populars','brands','sellers'));
    }

    public function bannerProduct($id)
    {
        $banner = Banner::query()->findOrFail($id);

        if(!Cookie::has('total_click-'.$id)){
            $banner->increment('total_click');
            Cookie::queue(Cookie::forever('total_click-'.$id,'clicked'));
        }

        if($banner->product_id == 1){
            return $this->product($banner->product->slug);
        }

        if($banner->brand_id == 1){
            return $this->brand($banner->brand->slug);
        }

        if($banner->category_id == 1){
            return $this->category($banner->category->slug);
        }

    }

    /**
     * Display individual brand page
     *
     * @param $slug
     * @return View
     */
    public function brand($slug): View
    {
        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $brand = Brand::query()
            ->where('slug',$slug)
            ->firstOr(function(){
                abort(404);
            });

        $title = $brand->name;

        $sellers = Seller::query()
            ->where('is_active',1)
            ->where('is_suspended',0)
            ->has('products')
            ->get();

        $sizes = Size::query()->where('is_active',1)->get();

        $colors = Color::query()
            ->where('is_active',1)
            ->where('display_in_search',1)
            ->get();

        $prices = collect(['min'=>0,'max'=>5000,'values'=>[75,1000]]);

        $products = Product::query()->active()->where('brand_id',$brand->id)->paginate(24);

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        return view('frontend.pages.shop',compact('title','brand','categories','brands','sellers','sizes','colors','prices','populars','products'));
    }

    public function category($slug)
    {
        $categories = $this->categories();

        $category = Category::query()
            ->where('slug',$slug)
            ->firstOr(function(){
                abort(404);
            });

        $title = $category->name;

        $brands = Brand::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active',1)
            ->where('is_suspended',0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $cats[] = $category->id;
        foreach($category->subCategories as $category){
            $cats[] = $category->id;
            foreach($category->subCategories as $category){
                $cats[] = $category->id;
            }
        }

        $products = Product::query()
            ->whereIn('category_id',$cats)
            ->where('is_active',1)
            ->paginate(24);

        $sizes = Size::query()->where('is_active',1)->get();

        $colors = Color::query()
            ->where('is_active',1)
            ->where('display_in_search',1)
            ->get();

        $prices = collect(['min'=>0,'max'=>5000,'values'=>[75,1000]]);

        return view('frontend.pages.shop',compact('title','category','categories','sizes','colors','prices','populars','products','brands','sellers'));
    }

    public function product($slug)
    {
        $product = Product::query()
            ->where('slug',$slug)
            ->firstOr(function(){
                abort(404);
            });

        $product->increment('total_viewed');

        $hasReview = ProductReview::query()->where('publish_stat',1)->where('product_id',$product->id)->exists();

        if($hasReview){
            $rating = $product->reviews->sum('review_point') / $product->reviews->count();
        }else{
            $rating = 0;
        }

        $similarProducts = Product::query()->inRandomOrder()->take(5)->get();

        return view('frontend.pages.product-details',compact('product','rating','similarProducts'));
    }

    /**
     * Display shopping cart page
     *
     * @return View
     */
    public function cart(): View
    {
        $cart = Cookie::get('cart');
        $carts = json_decode($cart);

        return view('frontend.pages.cart',compact('carts'));
    }

    /**
     * Display cancel message
     *
     * @return View
     */
    public function paymentCancel(): View
    {
        $msg = trans('Alas! Unable to process payment.');
        return view('frontend.pages.payment-cancel',compact('msg'));
    }

    public function page($url)
    {
        $menu = Menu::query()->where('url','like','%'.$url.'%')->first();

        $page = $menu->page;

        if(!$page){
            return view('frontend.errors.404');
        }

        return view('frontend.pages.blank',compact('page'));
    }

    public function dealOfTheWeek(Request $request)
    {
        $tab = $request->get('tab');

        if($tab == 'trends'){
            $products = Product::query()->inRandomOrder()->take(5)->get();
        }elseif($tab == 'new-arrivals'){
            $products = Product::query()
                ->where('is_active',1)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }elseif($tab == 'best-seller'){
            $products = Product::query()
                ->where('is_active',1)
                ->inRandomOrder()
                ->take(5)
                ->get();
        }elseif($tab == 'our-featured'){
            $products = Product::query()
                ->whereHas('details',function($q){
                    $q->where('is_featured',1);
                })
                ->inRandomOrder()
                ->take(5)
                ->get();
        }else{
            $products = Product::query()
                ->where('is_active',1)
                ->inRandomOrder()
                ->take(5)
                ->get();
        }

        return view('frontend.pages._ajax-deal-of-the-week-products',compact('products'));
    }

    public function bestSelling()
    {
        $title = 'Best Selling';

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active',1)
            ->where('is_suspended',0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $products = Product::query()
            ->active()
            ->whereHas('details',function($q){
                $q->where('is_best_sell',1);
            })
            ->inRandomOrder()
            ->paginate(24);

        $sizes = Size::query()->where('is_active',1)->get();
        $colors = Color::query()
            ->where('is_active',1)
            ->where('display_in_search',1)
            ->get();
        $prices = collect(['min'=>0,'max'=>5000,'values'=>[75,1000]]);

        return view('frontend.pages.shop',compact('products','title','categories','sizes','colors','prices','brands','sellers','populars'));
    }

    public function newArrivals()
    {
        $title = 'New Arrivals';

        $products = Product::query()
            ->active()
            ->orderByDesc('created_at')
            ->paginate(24);

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active',1)
            ->where('is_suspended',0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $sizes = Size::query()->where('is_active',1)->get();
        $colors = Color::query()
            ->where('is_active',1)
            ->where('display_in_search',1)
            ->get();
        $prices = collect(['min'=>0,'max'=>5000,'values'=>[75,1000]]);

        return view('frontend.pages.shop',compact('products','categories','sizes','colors','prices','brands','sellers','populars','title'));

    }

    public function trends()
    {
        $title = 'Trending';

        $products = Product::query()
            ->active()
            ->orderByDesc('total_viewed')
            ->paginate(24);

        $categories = $this->categories();

        $brands = Brand::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->has('products')
            ->take(7)
            ->get();

        $sellers = Seller::query()
            ->where('is_active',1)
            ->where('is_suspended',0)
            ->has('products')
            ->get();

        $populars = Product::query()->inRandomOrder()->take(4)->get();

        $sizes = Size::query()->where('is_active',1)->get();
        $colors = Color::query()
            ->where('is_active',1)
            ->where('display_in_search',1)
            ->get();
        $prices = collect(['min'=>0,'max'=>5000,'values'=>[75,1000]]);

        return view('frontend.pages.shop',compact('products','categories','sizes','colors','prices','brands','sellers','populars','title'));

    }

    public function brands()
    {
        $brands = Brand::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->has('products')
            ->get();

        return view('frontend.pages.all-brands',compact('brands'));
    }

    public function aboutUs()
    {
        $page = (object)config('constants.about-us');
        return view('frontend.pages.blank',compact('page'));
    }

    public function customerService()
    {
        $page = (object)config('constants.customer-service');
        return view('frontend.pages.blank',compact('page'));
    }

    public function orderReturns()
    {
        $page = (object)config('constants.order-returns');
        return view('frontend.pages.blank',compact('page'));
    }

    public function privacyPolicy()
    {
        $page = (object)config('constants.privacy-policy');
        return view('frontend.pages.blank',compact('page'));
    }

    public function shippingPolicy()
    {
        $page = (object)config('constants.shipping-policy');
        return view('frontend.pages.blank',compact('page'));
    }

    public function sitemap()
    {
        $page = (object)config('constants.sitemap');
        return view('frontend.pages.blank',compact('page'));
    }

    public function support()
    {
        $page = (object)config('constants.support');
        return view('frontend.pages.blank',compact('page'));
    }

    public function helpline()
    {
        $page = (object)config('constants.helpline');
        return view('frontend.pages.blank',compact('page'));
    }

    public function affiliates()
    {
        $page = (object)config('constants.affiliates');
        return view('frontend.pages.blank',compact('page'));
    }

    public function liveSupport()
    {
        $page = (object)config('constants.live-support');
        return view('frontend.pages.blank',compact('page'));
    }

    public function customerCare()
    {
        $page = (object)config('constants.customer-care');
        return view('frontend.pages.blank',compact('page'));
    }

    /**
     * Resend email verification mail
     *
     * @return RedirectResponse
     */
    public function resend(): RedirectResponse
    {
        auth('customer')->user()->sendEmailVerificationNotification();
        return redirect()->back();
    }

    public function changeCurrency(Request $request)
    {
        $currency = Currency::query()->findOrFail($request->get('id'));

        $data = [
            'id' => $request->get('id'),
            'symbol' => $currency->symbol,
            'name' => $currency->name,
            'cc' => $currency->cc,
            'exchange_rate' => $currency->exchange_rate,
        ];

        Cookie::queue(Cookie::make('currency',json_encode($data),config('constants.cart_expire_min')));

        return response($data);
    }

    public function ajaxFilter(Request $request)
    {
        $p = Product::query();

        if($request->has('category')){
            $category = Category::query()->findOrFail($request->get('category'));

            $cats[] = $category->id;
            foreach($category->subCategories as $category){
                $cats[] = $category->id;
                foreach($category->subCategories as $category){
                    $cats[] = $category->id;
                }
            }

            $p->whereIn('category_id',$cats);
        }

        if($request->has('color')){
            $colors = $request->get('color');
            $p->whereHas('colors',function($q)use($colors){
                $q->whereIn('color_id',$colors);
            });
        }

        if($request->has('size')){
            $sizes = $request->get('size');
            $p->whereHas('sizes',function($q)use($sizes){
                $q->whereIn('size_id',$sizes);
            });
        }

        if($request->has('brand')){
            $brand = $request->get('brand');
            $p->whereIn('brand_id',$brand);
        }

        if($request->has('seller')){
            $seller = $request->get('seller');
            $p->whereIn('seller_id',$seller);
        }

        if($request->has('min') && $request->has('max')){
            $min = $request->get('min');
            $max = $request->get('max');
            if($min >= 0 && $max > 0){
                $p->whereBetween('sale_price',[$min,$max]);
            }
        }

        if($request->has('sorting')){
            $sortBy = $request->get('sorting');
            if($sortBy == "price"){
                $p->orderBy('sale_price');
            }elseif($sortBy == "popularity"){
                $p->orderByDesc('total_viewed');
            }else{
                $p->orderBy('id');
            }
        }

        if($request->has('page')){
            $page = $request->get('page');
            $p->skip($page*12);
        }

        $products = $p->where('is_active',1)->paginate(24);

        return view('frontend.pages._ajax-product',compact('products'));
    }

    public function suggest(Request $request)
    {
        $products = Product::query()
            ->where('name','like','%'.$request->get('query').'%')
            ->inRandomOrder()
            ->take(4)
            ->get();

        $pro = [];

        foreach($products as $product){
            $pro[] = [
                'name' => $product->name,
                'image' => asset('uploads/products/galleries').'/'.$product->images->first()->image,
                'link' => route('product',$product->slug)
            ];
        }

        $data['suggests'] = ['_'=>$pro];

        return response(json_encode($data));
    }

    /**
     * Store email subscriber to database
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function subscribe(Request $request): RedirectResponse
    {
        $this->validate($request,[
            'email' => 'required|email|unique:email_subscribers',
        ]);

        $email = $request->get('email');

        EmailSubscriber::query()->create(['email'=>$email]);

        Session::flash('success','You are listed in our daily newsletter');

        return redirect()->back();
    }

    /**
     * A collection of active categories
     *
     * @return Collection
     */
    public function categories(): Collection
    {
        return Category::query()
            ->where('is_active',1)
            ->orderBy('order')
            ->where('category_id',null)
            ->take(12)
            ->get();
    }

}
