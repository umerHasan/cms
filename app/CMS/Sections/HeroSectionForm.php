<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, Select, FileUpload, Group};
use App\Models\Page;

class HeroSectionForm
{
    public static function schema(): array
    {
        return [
            Grid::make(12)->schema([
                FileUpload::make('image_path')
                    ->disk('public')->directory('uploads/sections/hero')
                    ->image()->imageEditor()->columnSpan(12),

                TextInput::make('title')->required()->maxLength(255)->columnSpan(6),
                Textarea::make('description')->rows(3)->columnSpan(6),

                Group::make()->schema([
                    TextInput::make('primary_button_text')->maxLength(255),
                    Select::make('primary_button_type')
                        ->options(['internal'=>'Internal','external'=>'External'])
                        ->required()->live(),
                    Select::make('primary_button_page_id')
                        ->label('Primary Internal Page')
                        ->relationship('primaryInternalPage','title')
                        ->searchable()
                        ->visible(fn($get) => $get('primary_button_type') === 'internal'),
                    TextInput::make('primary_button_url')
                        ->label('Primary External URL')
                        ->url()
                        ->visible(fn($get) => $get('primary_button_type') === 'external'),
                ])->columns(2)->columnSpan(12),

                Group::make()->schema([
                    TextInput::make('secondary_button_text')->maxLength(255),
                    Select::make('secondary_button_type')
                        ->options(['internal'=>'Internal','external'=>'External'])
                        ->required()->live(),
                    Select::make('secondary_button_page_id')
                        ->label('Secondary Internal Page')
                        ->relationship('secondaryInternalPage','title')
                        ->searchable()
                        ->visible(fn($get) => $get('secondary_button_type') === 'internal'),
                    TextInput::make('secondary_button_url')
                        ->label('Secondary External URL')
                        ->url()
                        ->visible(fn($get) => $get('secondary_button_type') === 'external'),
                ])->columns(2)->columnSpan(12),
            ]),
        ];
    }
}
