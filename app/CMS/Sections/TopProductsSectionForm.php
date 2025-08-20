<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, Select};
use App\Models\Product;

class TopProductsSectionForm
{
    public static function schema(): array
    {
        return [
            Grid::make(12)->schema([
                TextInput::make('title')->required()->maxLength(255)->columnSpan(6),
                Textarea::make('body')->rows(3)->columnSpan(6),

                // Product picker with "create new" inline modal
                Select::make('products')
                    ->label('Products')
                    ->relationship('products','name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('price')->numeric()->required(),
                        TextInput::make('sku')->maxLength(64)->unique(ignoreRecord: true),
                        \Filament\Forms\Components\FileUpload::make('image_path')
                            ->disk('public')->directory('uploads/products')->image()->imageEditor(),
                    ])
                    ->columnSpan(12),
            ]),
        ];
    }
}
