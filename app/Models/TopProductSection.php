<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopProductSection extends Model
{
    protected $fillable = [
        'title','title_ur', 'body','body_ur',
        'button_text','button_text_ur','button_type','button_page_id','button_url',
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'product_top_product_section')
            ->withTimestamps()
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }

    public function internalPage(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'button_page_id');
    }

    public function getButtonUrlAttribute(): ?string
    {
        if ($this->button_type === 'internal') {
            return $this->internalPage?->full_path ? url($this->internalPage->full_path) : null;
        }
        // Return the raw stored value to avoid accessor recursion
        return $this->attributes['button_url'] ?? null;
    }
}
