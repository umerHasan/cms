<?php

namespace App\CMS\Sections;

use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, Select, FileUpload, Section};
use Filament\Forms\Get;

class HeroSectionForm
{
    public static function schema(): array
    {
        return [
            Section::make('Hero Content')
                ->description('Headline, copy, and media for the hero area')
                ->schema([
                    Grid::make(12)->schema([
                        FileUpload::make('image_path')
                            ->label('Hero Image')
                            ->disk('public')
                            ->directory('uploads/sections/hero')
                            ->image()
                            ->imageEditor()
                            ->columnSpan(12),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(6),

                        Textarea::make('description')
                            ->label('Body')
                            ->rows(4)
                            ->columnSpan(6),
                    ]),
                ])
                ->collapsible()
                ->collapsed(false),

            Section::make('Primary Action')
                ->schema([
                    Grid::make(12)->schema([
                        TextInput::make('primary_button_text')
                            ->label('Button text')
                            ->maxLength(255)
                            ->columnSpan(4),
                        Select::make('primary_button_type')
                            ->label('Link type')
                            ->options(['internal' => 'Internal page', 'external' => 'External URL'])
                            ->required()
                            ->live()
                            ->columnSpan(3),
                        // NOTE: use options() instead of relationship() to avoid RelationManager owner-model issues
                        Select::make('primary_button_page_id')
                            ->label('Internal page')
                            ->options(fn () => Page::query()->orderBy('title')->pluck('title', 'id'))
                            ->searchable()
                            ->visible(fn (Get $get) => $get('primary_button_type') === 'internal')
                            ->columnSpan(5),
                        TextInput::make('primary_button_url')
                            ->label('External URL')
                            ->url()
                            ->visible(fn (Get $get) => $get('primary_button_type') === 'external')
                            ->columnSpan(5),
                    ]),
                ])
                ->collapsible(),

            Section::make('Secondary Action')
                ->schema([
                    Grid::make(12)->schema([
                        TextInput::make('secondary_button_text')
                            ->label('Button text')
                            ->maxLength(255)
                            ->columnSpan(4),
                        Select::make('secondary_button_type')
                            ->label('Link type')
                            ->options(['internal' => 'Internal page', 'external' => 'External URL'])
                            ->required()
                            ->live()
                            ->columnSpan(3),
                        Select::make('secondary_button_page_id')
                            ->label('Internal page')
                            ->options(fn () => Page::query()->orderBy('title')->pluck('title', 'id'))
                            ->searchable()
                            ->visible(fn (Get $get) => $get('secondary_button_type') === 'internal')
                            ->columnSpan(5),
                        TextInput::make('secondary_button_url')
                            ->label('External URL')
                            ->url()
                            ->visible(fn (Get $get) => $get('secondary_button_type') === 'external')
                            ->columnSpan(5),
                    ]),
                ])
                ->collapsible(),
        ];
    }
}
