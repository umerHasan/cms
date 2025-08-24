<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\{TextInput, Toggle, FileUpload, DateTimePicker, RichEditor, Tabs, Textarea};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, IconColumn};
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = 'CMS';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('i18n')
                ->tabs([
                    Tabs\Tab::make('English')->schema([
                        TextInput::make('title')->required()->maxLength(255)->columnSpan(12),
                        TextInput::make('author_name')->label('Author')->maxLength(255)->columnSpan(12),
                        TextInput::make('excerpt')->maxLength(255)->columnSpan(12),
                        RichEditor::make('body')
                            ->toolbarButtons([
                                'blockquote', 'bold', 'bulletList', 'orderedList', 'italic', 'strike', 'underline',
                                'h2', 'h3', 'link', 'codeBlock', 'redo', 'undo', 'attachFiles',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('uploads/posts/body')
                            ->columnSpanFull(),
                    ])->columns(12),
                    Tabs\Tab::make('Urdu')->schema([
                        TextInput::make('title_ur')->label('Title (Urdu)')->maxLength(255)->columnSpan(12),
                        TextInput::make('author_name_ur')->label('Author (Urdu)')->maxLength(255)->columnSpan(12),
                        TextInput::make('excerpt_ur')->label('Excerpt (Urdu)')->maxLength(255)->columnSpan(12),
                        RichEditor::make('body_ur')
                            ->label('Body (Urdu)')
                            ->toolbarButtons([
                                'blockquote', 'bold', 'bulletList', 'orderedList', 'italic', 'strike', 'underline',
                                'h2', 'h3', 'link', 'codeBlock', 'redo', 'undo', 'attachFiles',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('uploads/posts/body')
                            ->columnSpanFull(),
                    ])->columns(12),
                ])
                ->columnSpanFull(),
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->columnSpan(12),
            DateTimePicker::make('published_at')->label('Publish date')->columnSpan(6),
            Toggle::make('is_published')->default(true)->columnSpan(6),
            FileUpload::make('image_path')->disk('public')->directory('uploads/posts')->image()->imageEditor()->columnSpan(12),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable(),
            TextColumn::make('slug')->searchable(),
            TextColumn::make('author_name')->label('Author'),
            TextColumn::make('published_at')->dateTime()->since(),
            IconColumn::make('is_published')->boolean(),
        ])->defaultSort('published_at','desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
