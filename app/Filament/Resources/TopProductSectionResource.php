<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TopProductSectionResource\Pages;
use App\Filament\Resources\TopProductSectionResource\RelationManagers;
use App\Models\TopProductSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TopProductSectionResource extends Resource
{
    protected static ?string $model = TopProductSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTopProductSections::route('/'),
            'create' => Pages\CreateTopProductSection::route('/create'),
            'edit' => Pages\EditTopProductSection::route('/{record}/edit'),
        ];
    }
}
