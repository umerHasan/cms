<?php

namespace App\CMS\Sections;

use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, FileUpload, Repeater, Section};

class TestimonialsSectionForm
{
    public static function schema(): array
    {
        return [
            Section::make('Header')
                ->schema([
                    TextInput::make('title')
                        ->label('Section Title')
                        ->default('Testimonials')
                        ->maxLength(255)
                        ->columnSpan(6),
                ])
                ->collapsible(),

            Section::make('Testimonials')
                ->description('Add one or more testimonials.')
                ->schema([
                    Repeater::make('testimonials')
                        ->label('Items')
                        ->default([])
                        ->reorderable(true)
                        ->schema([
                            Grid::make(12)->schema([
                                Textarea::make('quote')
                                    ->label('Quote')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpan(12),

                                TextInput::make('author_name')
                                    ->label('Author Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(6),

                                TextInput::make('author_title')
                                    ->label('Author Title/Position')
                                    ->maxLength(255)
                                    ->columnSpan(6),

                                FileUpload::make('author_image')
                                    ->label('Author Image')
                                    ->disk('public')
                                    ->directory('uploads/testimonials')
                                    ->image()
                                    ->imageEditor()
                                    ->columnSpan(12),
                            ]),
                        ])
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->collapsed(false),
        ];
    }
}

