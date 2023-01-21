<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\ResponseMessage;
use App\Models\Api\Announcement;
use App\Models\Api\Banner;
use App\Models\Api\FAQ;
use App\Models\Api\Menu;
use Illuminate\Http\JsonResponse;

class WebsiteController extends Controller
{
    use ResponseMessage, ApiResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function page($url) :JsonResponse
    {
        $menu = Menu::query()->where('url','like','%'.$url.'%')->first();

        $page = $menu->page;
        if($page){
            return $this->successResponse($page,$this->load_success['message']);
        }else{
            return $this->successResponse('',$this->not_found_message['message']);
        }
    }

    public function banners() :JsonResponse
    {
        $banners = Banner::query()
            ->where('is_active',1)
            ->where('publish_stat',1)
            ->where(function($q){
                $q->where('expire_at','>',now())->orWhere('expire_at',null);
            })
            ->orderByDesc('id')
            ->limit(5)
            ->get();
        if(count($banners)){
            return $this->successResponse($banners,$this->load_success['message']);
        }else{
            return $this->successResponse('',$this->not_found_message['message']);
        }
    }

    public function faq(): JsonResponse
    {
        $faqs = FAQ::query()->where('is_active',1)->paginate(6);
        return $this->successResponse($faqs,$this->load_success['message']);
    }

    public function announcements(): JsonResponse
    {
        $announcements = Announcement::query()
            ->where('is_active',1)
            ->where('expire_at','>',now())
            ->get();
        return $this->successResponse($announcements,$this->load_success['message']);
    }
}
