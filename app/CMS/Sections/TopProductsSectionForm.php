<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, Select, FileUpload};
use App\Models\Product;

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
        ];
    }
}
