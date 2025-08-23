<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialSection extends Model
{
    protected $fillable = [
        'title', 'testimonials',
    ];

    protected $casts = [
        'testimonials' => 'array',
    ];
}

