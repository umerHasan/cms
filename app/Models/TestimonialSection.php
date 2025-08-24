<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialSection extends Model
{
    protected $fillable = [
        'title', 'title_ur', 'testimonials', 'testimonials_ur',
    ];

    protected $casts = [
        'testimonials' => 'array',
        'testimonials_ur' => 'array',
    ];
}
