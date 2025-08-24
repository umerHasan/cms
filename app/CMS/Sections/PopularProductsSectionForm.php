<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, FileUpload, Repeater, Section, Select, Placeholder, Tabs};
use Filament\Forms\Get;
use App\Models\Product;
use App\Filament\Resources\ProductResource;

class PopularProductsSectionForm
{
    public static function schema(): array
    {
        return [
            Grid::make(12)->schema([
                Tabs::make('i18n_header')
                    ->tabs([
                        Tabs\Tab::make('English')->schema([
                            TextInput::make('title')->label('Title')->maxLength(255)->columnSpan(6),
                        ])->columns(12),
                        Tabs\Tab::make('Urdu')->schema([
                            TextInput::make('title_ur')->label('Title (Urdu)')->maxLength(255)->columnSpan(6),
                        ])->columns(12),
                    ])->columnSpan(12),
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
                                    ->createOptionForm([
                                        Tabs::make('i18n')
                                            ->tabs([
                                                Tabs\Tab::make('English')->schema([
                                                    TextInput::make('name')->required()->maxLength(255),
                                                    Forms\Components\Textarea::make('description')->rows(3),
                                                ]),
                                                Tabs\Tab::make('Urdu')->schema([
                                                    TextInput::make('name_ur')->label('Name (Urdu)')->maxLength(255),
                                                    Forms\Components\Textarea::make('description_ur')->label('Description (Urdu)')->rows(3),
                                                ]),
                                            ]),
                                        TextInput::make('price')->numeric(),
                                        TextInput::make('sku')->maxLength(64)->unique(ignoreRecord: true),
                                        FileUpload::make('image_path')->disk('public')->directory('uploads/products')->image()->imageEditor(),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $product = Product::create($data);
                                        return $product->getKey();
                                    })
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
