<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSection extends Model
{
    protected $fillable = [
        'title','view_all_text','view_all_type','view_all_page_id','view_all_url'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'blog_section_post')
            ->withTimestamps()
            ->withPivot('sort_order')
            ->orderByPivot('sort_order');
    }

    public function viewAllPage()
    {
        return $this->belongsTo(Page::class, 'view_all_page_id');
    }

    public function getViewAllHrefAttribute(): ?string
    {
        if (($this->attributes['view_all_type'] ?? null) === 'internal') {
            return $this->viewAllPage?->full_path ? url($this->viewAllPage->full_path) : null;
        }
        return $this->attributes['view_all_url'] ?? null;
    }
}

