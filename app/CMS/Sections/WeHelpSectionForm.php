<?php

namespace App\CMS\Sections;

use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, FileUpload, Repeater, Section, Select, Tabs};
use Filament\Forms\Get;

class WeHelpSectionForm
{
    public static function schema(): array
    {
        return [
            Section::make('Content')
                ->schema([
                    Grid::make(12)->schema([
                        Tabs::make('i18n_content')
                            ->tabs([
                                Tabs\Tab::make('English')->schema([
                                    TextInput::make('title')->label('Title')->required()->maxLength(255)->columnSpan(6),
                                    Textarea::make('body')->label('Body')->rows(3)->columnSpan(6),
                                ])->columns(12),
                                Tabs\Tab::make('Urdu')->schema([
                                    TextInput::make('title_ur')->label('Title (Urdu)')->maxLength(255)->columnSpan(6),
                                    Textarea::make('body_ur')->label('Body (Urdu)')->rows(3)->columnSpan(6),
                                ])->columns(12),
                            ])->columnSpan(12),
                    ]),
                ])
                ->collapsible(),

            Section::make('Grid Images')
                ->schema([
                    Grid::make(12)->schema([
                        FileUpload::make('grid_image_1')->label('Grid Image 1')->disk('public')->directory('uploads/sections/we-help')->image()->imageEditor()->columnSpan(4),
                        FileUpload::make('grid_image_2')->label('Grid Image 2')->disk('public')->directory('uploads/sections/we-help')->image()->imageEditor()->columnSpan(4),
                        FileUpload::make('grid_image_3')->label('Grid Image 3')->disk('public')->directory('uploads/sections/we-help')->image()->imageEditor()->columnSpan(4),
                    ]),
                ])
                ->collapsible(),

            Section::make('Bullet Points')
                ->schema([
                    Tabs::make('i18n_list')
                        ->tabs([
                            Tabs\Tab::make('English')->schema([
                                Repeater::make('list_items')
                                    ->label('Items')
                                    ->default([])
                                    ->reorderable(true)
                                    ->schema([
                                        TextInput::make('text')->label('Text')->maxLength(255)->required(),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                            Tabs\Tab::make('Urdu')->schema([
                                Repeater::make('list_items_ur')
                                    ->label('Items (Urdu)')
                                    ->default([])
                                    ->reorderable(true)
                                    ->schema([
                                        TextInput::make('text')->label('Text (Urdu)')->maxLength(255)->required(),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        ]),
                ])
                ->collapsible(),

            Section::make('CTA Button')
                ->schema([
                    Grid::make(12)->schema([
                        Tabs::make('i18n_button')
                            ->tabs([
                                Tabs\Tab::make('English')->schema([
                                    TextInput::make('button_text')->label('Button text')->maxLength(255)->columnSpan(12),
                                ]),
                                Tabs\Tab::make('Urdu')->schema([
                                    TextInput::make('button_text_ur')->label('Button text (Urdu)')->maxLength(255)->columnSpan(12),
                                ]),
                            ])->columnSpan(4),
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
