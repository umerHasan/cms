<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title','title_ur','slug','excerpt','excerpt_ur','body','body_ur','image_path','author_name','author_name_ur','published_at','is_published'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'bool',
    ];

    public function getDetailUrlAttribute(): ?string
    {
        return $this->slug ? url('/blog/' . $this->slug) : null;
    }
}
