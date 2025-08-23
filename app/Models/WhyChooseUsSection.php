<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUsSection extends Model
{
    protected $fillable = [
        'title', 'body', 'image_path', 'features',
    ];

    protected $casts = [
        'features' => 'array',
    ];
}

