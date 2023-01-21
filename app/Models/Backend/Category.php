<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'order',
        'icon',
        'banner',
        'meta_title',
        'meta_description',
        'slug',
        'commission_rate',
        'show_in_home',
        'is_active',
    ];
}
