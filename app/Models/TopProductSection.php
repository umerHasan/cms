<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopProductSection extends Model
{
    protected $fillable = ['title','body'];

    public function products() {
        return $this->belongsToMany(Product::class, 'product_top_product_section')
            ->withTimestamps()
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }
}
