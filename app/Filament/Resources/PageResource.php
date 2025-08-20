<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers\SectionsRelationManager;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\{TextInput, Select, Toggle, Grid, Textarea};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, IconColumn};
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'CMS';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                TextInput::make('title')->required()->maxLength(255)->columnSpan(6),
                Select::make('parent_id')
                    ->relationship('parent','title')
                    ->searchable()
                    ->preload()
                    ->columnSpan(6),
                TextInput::make('slug')
                    ->required()
                    ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/') // kebab-case
                    ->unique(ignoreRecord: true, modifyRuleUsing: fn($rule, $get) =>
                        $rule->where('parent_id', $get('parent_id'))
                    )
                    ->helperText('kebab-case, unique among siblings')
                    ->columnSpan(6),

                Toggle::make('is_published')->inline(false)->columnSpan(3),
                TextInput::make('meta_title')->maxLength(255)->columnSpan(6),
                Textarea::make('meta_description')->rows(3)->columnSpan(12),
                TextInput::make('meta_keywords')->helperText('Comma-separated')->columnSpan(12),

                // Computed preview (read-only)
                TextInput::make('full_path')->disabled()->dehydrated(false)->columnSpan(12),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('full_path')->badge()->copyable(),
                IconColumn::make('is_published')->boolean(),
                TextColumn::make('updated_at')->dateTime()->since(),
            ])
            ->defaultSort('updated_at','desc');
    }

    public static function getRelations(): array
    {
        return [
            SectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit'   => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
