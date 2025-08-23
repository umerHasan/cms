<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','slug','description','price','image_path','sku','is_active'];
    protected $casts = ['is_active' => 'bool'];

    public function getDetailUrlAttribute(): ?string
    {
        return $this->slug ? url('/products/' . $this->slug) : null;
    }
}
