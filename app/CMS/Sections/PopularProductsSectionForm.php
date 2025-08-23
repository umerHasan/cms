<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, FileUpload, Repeater, Section, Select, Placeholder};
use Filament\Forms\Get;
use App\Models\Product;
use App\Filament\Resources\ProductResource;

class PopularProductsSectionForm
{
    public static function schema(): array
    {
        return [
            Grid::make(12)->schema([
                TextInput::make('title')->label('Title')->maxLength(255)->columnSpan(6),
            ]),

            Section::make('Products')
                ->description('Choose and order products to feature.')
                ->schema([
                    Repeater::make('product_items')
                        ->label('Products')
                        ->default([])
                        ->reorderable(true)
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(12)->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->searchable()
                                    ->preload()
                                    ->options(fn () => Product::query()->orderBy('name')->pluck('name','id')->all())
                                    ->getSearchResultsUsing(fn (string $search) =>
                                        Product::query()
                                            ->where('name', 'like', "%{$search}%")
                                            ->orderBy('name')
                                            ->limit(50)
                                            ->pluck('name', 'id')
                                            ->all()
                                    )
                                    ->getOptionLabelUsing(fn ($value) => Product::query()->whereKey($value)->value('name'))
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('manage')
                                            ->label('Manage')
                                            ->url(fn () => ProductResource::getUrl('index'))
                                            ->openUrlInNewTab()
                                    )
                                    ->columnSpan(6),

                                Placeholder::make('preview')
                                    ->label('Preview')
                                    ->content(function (Get $get) {
                                        $id = $get('product_id');
                                        if (!$id) return 'No product selected';
                                        $p = Product::query()->find($id, ['name','price','slug']);
                                        if (!$p) return 'No product selected';
                                        $price = is_null($p->price) ? '' : ' ($'.number_format($p->price,2).')';
                                        return e($p->name.$price.' • slug: '.$p->slug);
                                    })
                                    ->extraAttributes(['class' => 'text-sm text-gray-600'])
                                    ->columnSpan(6),

                                // Quick-create fields when adding a new product
                                Forms\Components\Fieldset::make('New product')
                                    ->schema([
                                        TextInput::make('name')->label('Name')->maxLength(255),
                                        TextInput::make('slug')->label('Slug')->maxLength(255),
                                        TextInput::make('price')->numeric(),
                                    ])
                                    ->columns(3)
                                    ->visible(false) // kept for future if we wire custom create flow
                                    ->columnSpan(12),
                            ]),
                        ]),
                ])
                ->collapsible()
                ->collapsed(false),
        ];
    }
}
