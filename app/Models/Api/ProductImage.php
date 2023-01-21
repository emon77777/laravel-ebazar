<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ProductImage extends Model
{
    use HasFactory;

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function getImageAttribute(): string
    {
        return URL::to('uploads/products/galleries'). '/' . $this->attributes['image'];
    }
}
