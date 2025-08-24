<?php

namespace App\CMS\Sections;

use App\Models\Page;
use App\Models\Post;
use App\Filament\Resources\PostResource;
use Filament\Forms;
use Filament\Forms\Components\{Grid, TextInput, Textarea, FileUpload, Repeater, Section, Select, Placeholder, Tabs};
use Filament\Forms\Get;

class BlogSectionForm
{
    public static function schema(): array
    {
        return [
            Grid::make(12)->schema([
                Tabs::make('i18n_header')
                    ->tabs([
                        Tabs\Tab::make('English')->schema([
                            TextInput::make('title')->label('Section Title')->default('Recent Blog')->maxLength(255)->columnSpan(6),
                            TextInput::make('view_all_text')->label('View-all Text')->default('View All Posts')->maxLength(255)->columnSpan(6),
                        ])->columns(12),
                        Tabs\Tab::make('Urdu')->schema([
                            TextInput::make('title_ur')->label('Section Title (Urdu)')->maxLength(255)->columnSpan(6),
                            TextInput::make('view_all_text_ur')->label('View-all Text (Urdu)')->maxLength(255)->columnSpan(6),
                        ])->columns(12),
                    ])->columnSpan(12),
            ]),

            Section::make('View All Link')
                ->schema([
                    Grid::make(12)->schema([
                        Select::make('view_all_type')->label('Link type')->options(['internal'=>'Internal page','external'=>'External URL'])->default('external')->live()->columnSpan(3),
                        Select::make('view_all_page_id')
                            ->label('Internal page')
                            ->options(fn () => Page::query()->orderBy('title')->pluck('title', 'id'))
                            ->searchable()
                            ->visible(fn (Get $get) => $get('view_all_type') === 'internal')
                            ->columnSpan(5),
                        TextInput::make('view_all_url')->label('External URL')->url()->visible(fn (Get $get) => $get('view_all_type') === 'external')->columnSpan(4),
                    ]),
                ])
                ->collapsible(),

            Section::make('Posts')
                ->description('Choose and order posts to show')
                ->schema([
                    Repeater::make('post_items')
                        ->label('Posts')
                        ->default([])
                        ->addActionLabel('Add Post')
                        ->reorderable(true)
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(12)->schema([
                                Select::make('post_id')
                                    ->label('Post')
                                    ->searchable()
                                    ->preload()
                                    ->options(fn () => Post::query()->orderBy('published_at','desc')->pluck('title','id')->all())
                                    ->getSearchResultsUsing(fn (string $search) =>
                                        Post::query()->where('title','like',"%{$search}%")->orderBy('published_at','desc')->limit(50)->pluck('title','id')->all()
                                    )
                                    ->createOptionForm([
                                        Tabs::make('i18n')
                                            ->tabs([
                                                Tabs\Tab::make('English')->schema([
                                                    TextInput::make('title')->required()->maxLength(255)->columnSpan(12),
                                                    TextInput::make('author_name')->label('Author')->maxLength(255)->columnSpan(12),
                                                    TextInput::make('excerpt')->maxLength(255)->columnSpan(12),
                                                    Forms\Components\RichEditor::make('body')
                                                        ->toolbarButtons([
                                                            'blockquote','bold','bulletList','orderedList','italic','strike','underline',
                                                            'h2','h3','link','codeBlock','redo','undo','attachFiles',
                                                        ])
                                                        ->fileAttachmentsDisk('public')
                                                        ->fileAttachmentsDirectory('uploads/posts/body')
                                                        ->columnSpanFull(),
                                                ])->columns(12),
                                                Tabs\Tab::make('Urdu')->schema([
                                                    TextInput::make('title_ur')->label('Title (Urdu)')->maxLength(255)->columnSpan(12),
                                                    TextInput::make('author_name_ur')->label('Author (Urdu)')->maxLength(255)->columnSpan(12),
                                                    TextInput::make('excerpt_ur')->label('Excerpt (Urdu)')->maxLength(255)->columnSpan(12),
                                                    Forms\Components\RichEditor::make('body_ur')
                                                        ->label('Body (Urdu)')
                                                        ->toolbarButtons([
                                                            'blockquote','bold','bulletList','orderedList','italic','strike','underline',
                                                            'h2','h3','link','codeBlock','redo','undo','attachFiles',
                                                        ])
                                                        ->fileAttachmentsDisk('public')
                                                        ->fileAttachmentsDirectory('uploads/posts/body')
                                                        ->columnSpanFull(),
                                                ])->columns(12),
                                            ]),
                                        TextInput::make('slug')->required()->unique(ignoreRecord: true)->columnSpan(12),
                                        Forms\Components\DateTimePicker::make('published_at')->label('Publish date')->columnSpan(6),
                                        Forms\Components\Toggle::make('is_published')->default(true)->columnSpan(6),
                                        Forms\Components\FileUpload::make('image_path')->disk('public')->directory('uploads/posts')->image()->imageEditor()->columnSpan(12),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        $post = Post::create($data);
                                        return $post->getKey();
                                    })
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('manage')
                                            ->label('Manage')
                                            ->url(fn () => PostResource::getUrl('index'))
                                            ->openUrlInNewTab()
                                    )
                                    ->columnSpan(6),
                                Placeholder::make('preview')
                                    ->label('Preview')
                                    ->content(function (Get $get) {
                                        $id = $get('post_id');
                                        if (!$id) return 'No post selected';
                                        $p = Post::query()->find($id, ['title','author_name','published_at']);
                                        if (!$p) return 'No post selected';
                                        $date = $p->published_at ? $p->published_at->format('M d, Y') : '';
                                        return e($p->title.' • '.$p->author_name.' • '.$date);
                                    })
                                    ->extraAttributes(['class' => 'text-sm text-gray-600'])
                                    ->columnSpan(6),
                            ]),
                        ]),
                ])
                ->collapsible()
                ->collapsed(false),
        ];
    }
}
