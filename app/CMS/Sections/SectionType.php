<?php

namespace App\CMS\Sections;

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
            'testimonials' => [
                'label' => 'Testimonials',
                'model' => \App\Models\TestimonialSection::class,
                'view'  => 'testimonials',
                'form'  => \App\CMS\Sections\TestimonialsSectionForm::class,
            ],
            'why-choose-us' => [
                'label' => 'Why Choose Us',
                'model' => \App\Models\WhyChooseUsSection::class,
                'view'  => 'why-choose-us',
                'form'  => \App\CMS\Sections\WhyChooseUsSectionForm::class,
            ],
            'we-help' => [
                'label' => 'We Help',
                'model' => \App\Models\WeHelpSection::class,
                'view'  => 'we-help',
                'form'  => \App\CMS\Sections\WeHelpSectionForm::class,
            ],
            'popular-products' => [
                'label' => 'Popular Products',
                'model' => \App\Models\PopularProductsSection::class,
                'view'  => 'popular-products',
                'form'  => \App\CMS\Sections\PopularProductsSectionForm::class,
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
