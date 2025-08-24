<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUsSection extends Model
{
    protected $fillable = [
        'title','title_ur', 'body','body_ur', 'image_path', 'features','features_ur',
    ];

    protected $casts = [
        'features' => 'array',
        'features_ur' => 'array',
    ];
}
