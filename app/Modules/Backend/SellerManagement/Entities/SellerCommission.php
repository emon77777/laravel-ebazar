<?php

namespace App\Modules\Backend\SellerManagement\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerCommission extends Model
{

    protected $fillable = [
        'seller_id', 'seller_commission', 'remarks'
    ];
}
