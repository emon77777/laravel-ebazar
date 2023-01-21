<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id','category_id','brand_id','name','unit','tags','minimum_qty','barcode','sku','is_refundable','attributes','unit_price','purchase_price','sale_price','discount','quantity','shipping_cost','description','pdf_specification','meta_title','meta_description','meta_image','slug','total_viewed','is_active','publish_stat'];
}
