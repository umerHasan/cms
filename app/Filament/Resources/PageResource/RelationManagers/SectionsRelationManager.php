<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use App\CMS\Sections\SectionType;
use App\Models\PageSection;
use Filament\Forms;
use Filament\Forms\Components\{Select, TextInput, Grid, Placeholder, Section};
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Get;
use Filament\Forms\Set;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';
    protected static ?string $title = 'Sections';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Grid::make()
                ->columns(12)
                ->schema([
                    Select::make('section_type')
                        ->label('Section Type')
                        ->options(collect(SectionType::all())->mapWithKeys(fn($d, $k) => [$k => $d['label']])->all())
                        ->placeholder('Choose a section type…')
                        ->searchable()
                        ->native(false)
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, $state) {
                              if (!$state) {            // <-- guard
                                  $set('view_file', '');
                                  return;
                              }
                              $def = SectionType::get($state);
                              $set('view_file', $def['view'] ?? '');
                          })

                        ->columnSpan(6),

                    TextInput::make('view_file')
                        ->label('View file')
                        ->helperText('Blade at resources/views/sections/{view_file}.blade.php')
                        ->placeholder(function (Get $get) {
                              $key = $get('section_type');
                              if (!$key) return '';
                              $def = SectionType::get($key);
                              return $def['view'] ?? '';
                          })

                        ->required()
                        ->columnSpan(6),
                ]),

            // Section fields area (hidden until a type is chosen)
            Section::make('Section Fields')
                ->schema(function (Get $get) {
                    $key = $get('section_type');
                    if (! $key) {
                        return [
                            Placeholder::make('note')
                                ->label('')
                                ->content('Select a type first.')
                                ->extraAttributes(['class' => 'text-sm text-gray-500']),
                        ];
                    }
                    $type = SectionType::get($key);
                    if (! $type) {
                        return [
                            Placeholder::make('note_invalid')
                                ->label('')
                                ->content('Invalid section type.')
                                ->extraAttributes(['class' => 'text-sm text-red-600']),
                        ];
                    }
                    $formClass = $type['form'];
                    return $formClass::schema();
                })
                ->collapsible()
                ->collapsed(false)
                ->columnSpanFull(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                BadgeColumn::make('section_type')->colors(['primary'])->label('Type'),
                TextColumn::make('view_file')->label('View'),
                TextColumn::make('sectionable_type')->label('Model')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->since(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Section')
                    ->modalWidth('5xl')
                    ->using(function (array $data): Model {
                        return DB::transaction(function () use ($data) {
                            $def = SectionType::get($data['section_type']);
                            $modelClass = $def['model'];
                    
                            /** @var Model $sectionable */
                            $sectionable = new $modelClass();
                            $sectionable->fill(self::extractConcreteSectionData($data, $data['section_type']))->save();
                    
                            $ps = PageSection::create([
                                'page_id'          => $this->ownerRecord->id,
                                'section_type'     => $data['section_type'],           // <— use selected key
                                'view_file'        => $data['view_file'] ?: $def['view'],
                                'sectionable_type' => $modelClass,
                                'sectionable_id'   => $sectionable->id,
                                'sort_order'       => (int) $this->ownerRecord->sections()->max('sort_order') + 1,
                            ]);
                    
                            if (method_exists($sectionable, 'products') && isset($data['products'])) {
                                $sync = [];
                                foreach (array_values($data['products']) as $i => $pid) {
                                    $sync[$pid] = ['sort_order' => $i];
                                }
                                $sectionable->products()->sync($sync);
                            }
                    
                            return $ps;
                        });
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('5xl')
                    // Pre-fill the form with the concrete section model's attributes
                    ->fillForm(function (Model $record): array {
                        $state = [
                            'section_type' => $record->section_type,
                            'view_file'    => $record->view_file,
                            'sort_order'   => $record->sort_order,
                        ];

                        $sectionable = $record->sectionable;
                        if ($sectionable) {
                            // Merge all fillable attributes from the concrete model
                            $state = array_merge($sectionable->toArray(), $state);

                            // If the section has products relation, prefill selected IDs in order
                            if (method_exists($sectionable, 'products')) {
                                $state['products'] = $sectionable->products()->pluck('id')->toArray();
                            }

                            // Ensure section_type/view fallback from the model if not stored
                            if (empty($state['section_type'])) {
                                $def = SectionType::forModel(get_class($sectionable));
                                if ($def) {
                                    $state['section_type'] = $def['key'];
                                    $state['view_file'] = $state['view_file'] ?: ($def['view'] ?? null);
                                }
                            }
                        }

                        return $state;
                    })
                    ->using(function (Model $record, array $data): Model {
                        return DB::transaction(function () use ($record, $data) {
                            $def = SectionType::get($data['section_type']);

                            $sectionable = $record->sectionable;
                            if (! $sectionable || get_class($sectionable) !== $def['model']) {
                                if ($sectionable) {
                                    $sectionable->delete();
                                }
                                $sectionable = new ($def['model']);
                            }
                    
                            $sectionable->fill(self::extractConcreteSectionData($data, $data['section_type']))->save();
                    
                            $record->update([
                                'section_type'     => $data['section_type'],           // <— use selected key
                                'view_file'        => $data['view_file'] ?: $def['view'],
                                'sectionable_type' => $def['model'],
                                'sectionable_id'   => $sectionable->id,
                            ]);
                    
                            if (method_exists($sectionable, 'products') && isset($data['products'])) {
                                $sync = [];
                                foreach (array_values($data['products']) as $i => $pid) {
                                    $sync[$pid] = ['sort_order' => $i];
                                }
                                $sectionable->products()->sync($sync);
                            }
                    
                            return $record->refresh();
                        });
                    }),
                    
                Tables\Actions\DeleteAction::make()
                    ->after(function (Model $record) {
                        optional($record->sectionable)->delete();
                    }),
            ]);
    }

    private static function extractConcreteSectionData(array $data, string $typeKey): array
    {
        $ignore = ['section_type','view_file','sort_order'];
        if ($typeKey === 'top-products') {
            $ignore[] = 'products';
        }
        return collect($data)->except($ignore)->all();
    }
}
