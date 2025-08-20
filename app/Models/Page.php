<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id','title','slug','full_path',
        'meta_title','meta_description','meta_keywords',
        'is_published','published_at','created_by','updated_by',
    ];

    protected $casts = [
        'is_published' => 'bool',
        'published_at' => 'datetime',
    ];

    public function parent() {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function sections() {
        // ordered sections with morphs
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    protected static function booted()
    {
        // Maintain full_path automatically
        static::saving(function (Page $page) {
            $slug = trim($page->slug ?? '', '/');
            if ($page->parent_id) {
                $parent = $page->parent()->first();
                $parentPath = $parent?->full_path ? trim($parent->full_path, '/') : '';
                $page->full_path = $parentPath ? ($parentPath.'/'.$slug) : $slug;
            } else {
                $page->full_path = $slug;
            }
        });

        // When parent path or slug changes, cascade update children
        static::saved(function (Page $page) {
            foreach ($page->children as $child) {
                $child->save(); // triggers saving() to recompute full_path
            }
        });
    }
}
