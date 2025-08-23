<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\{TextInput, Toggle, FileUpload};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, IconColumn};
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup = 'CMS';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            TextInput::make('price')->numeric()->required(),
            Forms\Components\Textarea::make('description')->rows(4),
            FileUpload::make('image_path')->disk('public')->directory('uploads/products')->image()->imageEditor(),
            Toggle::make('is_active'),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('slug')->searchable(),
            TextColumn::make('price')->money('usd', locale: 'en_US'),
            IconColumn::make('is_active')->boolean(),
        ])->defaultSort('updated_at','desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
