<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeHelpSection extends Model
{
    protected $fillable = [
        'title', 'body',
        'grid_image_1', 'grid_image_2', 'grid_image_3',
        'list_items',
        'button_text', 'button_type', 'button_page_id', 'button_url',
    ];

    protected $casts = [
        'list_items' => 'array',
    ];

    public function internalPage(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'button_page_id');
    }

    public function getButtonUrlAttribute(): ?string
    {
        if (($this->attributes['button_type'] ?? null) === 'internal') {
            return $this->internalPage?->full_path ? url($this->internalPage->full_path) : null;
        }
        return $this->attributes['button_url'] ?? null;
    }
}

