<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, Select, FileUpload, Section};
use App\Models\Product;
use App\Models\Page;
use Filament\Forms\Get;

class TopProductsSectionForm
{
    public static function schema(): array
    {
        return [
            Grid::make(12)->schema([
                TextInput::make('title')->required()->maxLength(255)->columnSpan(6),
                Textarea::make('body')->rows(3)->columnSpan(6),

                // ⬇️ use options(), not relationship()
                Select::make('products')
                    ->label('Products')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->options(Product::query()->pluck('name','id'))
                    ->createOptionForm([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('price')->numeric()->required(),
                        TextInput::make('sku')->maxLength(64)->unique(ignoreRecord: true),
                        FileUpload::make('image_path')
                            ->disk('public')->directory('uploads/products')->image()->imageEditor(),
                    ])
                    ->columnSpan(12),
            ]),

            Section::make('CTA Button')
                ->schema([
                    Grid::make(12)->schema([
                        TextInput::make('button_text')
                            ->label('Button text')
                            ->maxLength(255)
                            ->columnSpan(4),
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
