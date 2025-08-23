<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularProductsSection extends Model
{
    protected $fillable = [
        'title',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_popular_products_section')
            ->withTimestamps()
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }
}
