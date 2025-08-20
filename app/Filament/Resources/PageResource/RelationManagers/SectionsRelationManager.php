<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use App\CMS\SectionType;
use App\Models\PageSection;
use Filament\Forms;
use Filament\Forms\Components\{Select, TextInput, Fieldset, Grid, Placeholder};
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\{TextColumn, BadgeColumn};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';
    protected static ?string $title = 'Sections';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Grid::make(12)->schema([
                Select::make('section_type')
                    ->label('Section Type')
                    ->options(collect(SectionType::all())->mapWithKeys(fn($d, $k) => [$k => $d['label']])->all())
                    ->required()
                    ->reactive(),

                TextInput::make('view_file')
                    ->helperText('Blade at resources/views/sections/{view_file}.blade.php')
                    ->placeholder(fn($get) => SectionType::get($get('section_type'))['view'] ?? null)
                    ->required(),

                Fieldset::make('Section Fields')
                    ->schema(function ($get) {
                        $type = SectionType::get($get('section_type') ?? '');
                        if (! $type) {
                            return [Placeholder::make('p')->content('Select a type first.')];
                        }
                        $formClass = $type['form'];
                        return $formClass::schema();
                    })
                    ->columnSpan(12),
            ]),
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
                Tables\Actions\Action::make('addHero')
                    ->label('Add Hero')
                    ->action(fn() => $this->createSectionModal('hero')),
                Tables\Actions\Action::make('addTopProducts')
                    ->label('Add Top Products')
                    ->action(fn() => $this->createSectionModal('top-products')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        return DB::transaction(function () use ($record, $data) {
                            $def = SectionType::get($data['section_type']);
                            $sectionable = $record->sectionable;
                            if (! $sectionable || get_class($sectionable) !== $def['model']) {
                                if ($sectionable) $sectionable->delete();
                                $sectionable = new ($def['model']);
                            }
                            $sectionable->fill(self::extractConcreteSectionData($data, $def['key']))->save();

                            $record->update([
                                'section_type'      => $def['key'],
                                'view_file'         => $data['view_file'] ?: $def['view'],
                                'sectionable_type'  => $def['model'],
                                'sectionable_id'    => $sectionable->id,
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
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Section')
                    ->using(function (array $data): Model {
                        return DB::transaction(function () use ($data) {
                            $def = SectionType::get($data['section_type']);
                            $modelClass = $def['model'];
                            /** @var Model $sectionable */
                            $sectionable = new $modelClass();
                            $sectionable->fill(self::extractConcreteSectionData($data, $def['key']))->save();

                            $ps = PageSection::create([
                                'page_id'         => $this->ownerRecord->id,
                                'section_type'    => $def['key'],
                                'view_file'       => $data['view_file'] ?: $def['view'],
                                'sectionable_type'=> $modelClass,
                                'sectionable_id'  => $sectionable->id,
                                'sort_order'      => (int) $this->ownerRecord->sections()->max('sort_order') + 1,
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
                    }),
            ]);
    }

    protected function createSectionModal(string $typeKey): void
    {
        // Convenience quick-add launcher; relies on the CreateAction form
        $def = SectionType::get($typeKey);
        $this->mountedTableAction = 'create';
        $this->form->fill([
            'section_type' => $typeKey,
            'view_file'    => $def['view'],
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
