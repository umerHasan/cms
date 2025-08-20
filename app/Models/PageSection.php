<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'page_id','sectionable_type','sectionable_id',
        'section_type','view_file','sort_order',
    ];

    public function page() {
        return $this->belongsTo(Page::class);
    }

    public function sectionable() {
        return $this->morphTo();
    }
}

