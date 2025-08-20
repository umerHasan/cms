<?php

namespace App\CMS;

class SectionType
{
    public static function all(): array
    {
        // key => [label, model, view, formClass]
        return [
            'hero' => [
                'label' => 'Hero',
                'model' => \App\Models\HeroSection::class,
                'view'  => 'hero',
                'form'  => \App\CMS\Sections\HeroSectionForm::class,
            ],
            'top-products' => [
                'label' => 'Top Products',
                'model' => \App\Models\TopProductSection::class,
                'view'  => 'top-products',
                'form'  => \App\CMS\Sections\TopProductsSectionForm::class,
            ],
        ];
    }

    public static function get(string $key): ?array
    {
        return self::all()[$key] ?? null;
    }

    public static function forModel(string $class): ?array
    {
        foreach (self::all() as $key => $def) {
            if ($def['model'] === $class) {
                return ['key' => $key] + $def;
            }
        }
        return null;
    }
}
