<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','price','image_path','sku','is_active'];
    protected $casts = ['is_active' => 'bool'];
}
