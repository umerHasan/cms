<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, FileUpload, Repeater, Section};

class WhyChooseUsSectionForm
{
    public static function schema(): array
    {
        return [
            Section::make('Header')
                ->schema([
                    Grid::make(12)->schema([
                        TextInput::make('title')
                            ->label('Section Title')
                            ->default('Why Choose Us')
                            ->maxLength(255)
                            ->columnSpan(6),
                        Textarea::make('body')
                            ->label('Intro Text')
                            ->rows(3)
                            ->columnSpan(6),
                    ]),
                ])
                ->collapsible(),

            Section::make('Media')
                ->schema([
                    FileUpload::make('image_path')
                        ->label('Side Image')
                        ->disk('public')
                        ->directory('uploads/sections/why-choose-us')
                        ->image()
                        ->imageEditor(),
                ])
                ->collapsible(),

            Section::make('Features')
                ->description('Add one or more feature cards.')
                ->schema([
                    Repeater::make('features')
                        ->label('Cards')
                        ->default([])
                        ->reorderable(true)
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(12)->schema([
                                FileUpload::make('icon')
                                    ->label('Icon')
                                    ->disk('public')
                                    ->directory('uploads/sections/why-choose-us/icons')
                                    ->image()
                                    ->imageEditor()
                                    ->columnSpan(4),

                                TextInput::make('title')
                                    ->label('Title')
                                    ->maxLength(255)
                                    ->columnSpan(8),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(3)
                                    ->columnSpan(12),
                            ]),
                        ]),
                ])
                ->collapsible()
                ->collapsed(false),
        ];
    }
}

