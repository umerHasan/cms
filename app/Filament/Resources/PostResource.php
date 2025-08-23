<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\{TextInput, Toggle, FileUpload, DateTimePicker, RichEditor};
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
            TextInput::make('title')->required()->maxLength(255),
            TextInput::make('slug')->required()->unique(ignoreRecord: true),
            TextInput::make('author_name')->label('Author')->maxLength(255),
            DateTimePicker::make('published_at')->label('Publish date'),
            Toggle::make('is_published')->default(true),
            FileUpload::make('image_path')->disk('public')->directory('uploads/posts')->image()->imageEditor(),
            TextInput::make('excerpt')->maxLength(255),
            RichEditor::make('body')
                ->toolbarButtons([
                    'blockquote', 'bold', 'bulletList', 'orderedList', 'italic', 'strike', 'underline',
                    'h2', 'h3', 'link', 'codeBlock', 'redo', 'undo', 'attachFiles',
                ])
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('uploads/posts/body')
                ->columnSpanFull(),
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
