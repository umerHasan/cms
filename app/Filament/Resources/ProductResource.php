<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\{TextInput, Toggle, FileUpload, Textarea, Tabs};
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
            Tabs::make('i18n')
                ->tabs([
                    Tabs\Tab::make('English')->schema([
                        TextInput::make('name')->required()->maxLength(255),
                        Textarea::make('description')->rows(4),
                    ]),
                    Tabs\Tab::make('Urdu')->schema([
                        TextInput::make('name_ur')->label('Name (Urdu)')->maxLength(255),
                        Textarea::make('description_ur')->label('Description (Urdu)')->rows(4),
                    ]),
                ]),
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            TextInput::make('price')->numeric()->required(),
            FileUpload::make('image_path')->disk('public')->directory('uploads/products')->image()->imageEditor(),
            TextInput::make('sku')->maxLength(64),
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
