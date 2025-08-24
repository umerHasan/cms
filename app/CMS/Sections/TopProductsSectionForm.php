<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, Select, FileUpload, Section, Tabs};
use App\Models\Product;
use App\Models\Page;
use Filament\Forms\Get;

class TopProductsSectionForm
{
    public static function schema(): array
    {
        return [
            Grid::make(12)->schema([
                Tabs::make('i18n_header')
                    ->tabs([
                        Tabs\Tab::make('English')->schema([
                            TextInput::make('title')->required()->maxLength(255)->columnSpan(6),
                            Textarea::make('body')->rows(3)->columnSpan(6),
                        ])->columns(12),
                        Tabs\Tab::make('Urdu')->schema([
                            TextInput::make('title_ur')->label('Title (Urdu)')->maxLength(255)->columnSpan(6),
                            Textarea::make('body_ur')->label('Body (Urdu)')->rows(3)->columnSpan(6),
                        ])->columns(12),
                    ])->columnSpan(12),

                // ⬇️ use options(), not relationship()
                Select::make('products')
                    ->label('Products')
                    // Ensure the state is always an array for multiple select
                    ->default([])
                    ->multiple()
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
                    ->getOptionLabelUsing(fn ($value) =>
                        Product::query()->whereKey($value)->value('name')
                    )
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
                        TextInput::make('price')->numeric()->required(),
                        TextInput::make('sku')->maxLength(64)->unique(ignoreRecord: true),
                        FileUpload::make('image_path')->disk('public')->directory('uploads/products')->image()->imageEditor(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        $product = Product::create($data);
                        // Return the primary key to append to the field state; label resolved via getOptionLabelUsing()
                        return $product->getKey();
                    })
                    ->columnSpan(12),
            ]),

            Section::make('CTA Button')
                ->schema([
                    Grid::make(12)->schema([
                        Tabs::make('i18n_button')
                            ->tabs([
                                Tabs\Tab::make('English')->schema([
                                    TextInput::make('button_text')->label('Button text')->maxLength(255)->columnSpan(12),
                                ]),
                                Tabs\Tab::make('Urdu')->schema([
                                    TextInput::make('button_text_ur')->label('Button text (Urdu)')->maxLength(255)->columnSpan(12),
                                ]),
                            ])->columnSpan(4),
                        Select::make('button_type')
                            ->label('Link type')
                            ->options(['internal' => 'Internal page', 'external' => 'External URL'])
                            ->required()
                            ->default('internal')
                            ->live()
                            ->columnSpan(3),
                        Select::make('button_page_id')
                            ->label('Internal page')
                            ->options(fn () => Page::query()->orderBy('title')->pluck('title', 'id'))
                            ->searchable()
                            ->visible(fn (Get $get) => $get('button_type') === 'internal')
                            ->columnSpan(5),
                        TextInput::make('button_url')
                            ->label('External URL')
                            ->url()
                            ->visible(fn (Get $get) => $get('button_type') === 'external')
                            ->columnSpan(5),
                    ]),
                ])
                ->collapsible(),
        ];
    }
}
