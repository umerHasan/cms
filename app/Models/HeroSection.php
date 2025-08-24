<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'title','title_ur','description','description_ur','image_path',
        'primary_button_text','primary_button_text_ur','primary_button_type','primary_button_page_id','primary_button_url',
        'secondary_button_text','secondary_button_text_ur','secondary_button_type','secondary_button_page_id','secondary_button_url',
    ];

    public function primaryInternalPage() {
        return $this->belongsTo(Page::class, 'primary_button_page_id');
    }

    public function secondaryInternalPage() {
        return $this->belongsTo(Page::class, 'secondary_button_page_id');
    }

    // Helper: resolve URLs for blade
    public function getPrimaryUrlAttribute(): ?string {
        return $this->primary_button_type === 'internal'
            ? ($this->primaryInternalPage?->full_path ? url($this->primaryInternalPage->full_path) : null)
            : $this->primary_button_url;
    }

    public function getSecondaryUrlAttribute(): ?string {
        return $this->secondary_button_type === 'internal'
            ? ($this->secondaryInternalPage?->full_path ? url($this->secondaryInternalPage->full_path) : null)
            : $this->secondary_button_url;
    }
}
