<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use App\Models\User;
use Filament\Tables;
use App\Models\Periode;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Penilaian;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use App\Models\KategoriPenilaian;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\FastModeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FastModeResource\RelationManagers;
use App\Filament\Resources\FastModeResource\Pages\ManageFastModes;

class FastModeResource extends Resource
{
    protected static ?string $model = Penilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-forward';

    protected static ?string $modelLabel = 'Penilaian';

    protected static ?string $navigationGroup = 'Angka Kredit';

    protected static ?int $navigationSort = 13;

    protected static ?string $navigationLabel = 'Penilaian Cepat';

    protected static ?string $slug = 'angka-kredit-penilaian-cepat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Pegawai')
                    ->disabled(),
                Forms\Components\Select::make('parameter_id')
                    ->relationship('parameter', 'title')
                    ->label('Parameter')
                    ->disabled(),
                Forms\Components\TextInput::make('nilai')
                    ->label('Kuantitas')
                    ->hint(fn (Penilaian $penilaian) => $penilaian->parameter->hasil_kerja)
                    ->afterStateUpdated(function (Set $set, $state, Penilaian $record) {
                        if ($record->approval) {
                            $set('jumlah', (float)$state * (float)$record->parameter->angka_kredit);
                        } else {
                            $set('jumlah', null);
                        }
                    })
                    //->required()
                    ->disabled(fn (Get $get) => $get('approval') ? true : false)
                    ->numeric(),
                Forms\Components\FileUpload::make('file')
                    ->label('Unggah Berkas')
                    ->hint('Hanya file .pdf')
                    ->disabled(fn (Get $get) => $get('approval') ? true : false)
                    ->acceptedFileTypes(['application/pdf']),
                    //->required(),
                Forms\Components\Toggle::make('approval')
                    ->label('Status Verifikasi')
                    ->disabled(fn () => !(auth()->user()->hasRole(['super_admin', 'verifikator_pusat', 'verifikator_unit'])))
                    ->afterStateUpdated(function ($state, Penilaian $penilaian, Set $set) {
                        if ($state) {
                            $set('jumlah', ($penilaian->parameter->angka_kredit ?? 0) * ($penilaian->nilai ?? 0));
                            $set('komentar', null);
                        } else {
                            $set('jumlah', null);
                        }
                    })
                    ->live(),
                Forms\Components\Hidden::make('jumlah'),
                Forms\Components\Textarea::make('komentar')
                    ->hint('Berikan komentar jika ditolak')
                    ->afterStateUpdated(function ($state, Set $set) {
                        if ($state) {
                            $set('approval', false);
                        }
                    })
                    ->label('Catatan')
                    ->disabled(fn () => !(auth()->user()->hasRole(['super_admin', 'verifikator_pusat', 'verifikator_unit'])))
                    ->live(onBlur:true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pegawai')
                    ->sortable()
                    ->tooltip(fn (Penilaian $penilaian) => $penilaian->user->unit->nama . ' - ' . $penilaian->user->jabatan->title . ' - ' . $penilaian->user->golongan->nama)
                    ->wrap(),
                Tables\Columns\TextColumn::make('parameter_id')
                    ->sortable()
                    ->label('Parameter')
                    ->tooltip(fn (Penilaian $penilaian) => $penilaian->komentar ?? null)
                    ->color(fn (Penilaian $penilaian) => !$penilaian->file ? null : ($penilaian->komentar ? 'danger' : ($penilaian->approval ? 'success' : 'primary')) )
                    ->weight(fn (Penilaian $penilaian) => $penilaian->file ? FontWeight::Bold : FontWeight::Light)
                    ->formatStateUsing(function (Penilaian $penilaian) {
                        // Convert JSON to an associative array
                        $data = json_decode($penilaian->parameter->ancestors, true);

                        // Extract titles
                        $titles = array_column($data, 'title');

                        // Exclude the last two titles
                        $titlesToConcatenate = array_slice($titles, 0, -2);

                        // Concatenate titles with the separator
                        $resultString = implode(' - ', $titlesToConcatenate);

                        if ($resultString) {
                            $resultString = $resultString . ' - ' . $penilaian->parameter->title;
                        } else {
                            $resultString = $penilaian->parameter->title;
                        }
                        // Output the result
                        return $resultString;
                    })
                    ->description(function (Penilaian $penilaian) {
                        // Convert JSON to an associative array
                        $data = json_decode($penilaian->parameter->ancestors, true);

                        // Extract titles
                        $titles = array_column($data, 'title');

                        // Exclude the last two titles
                        $titlesToConcatenate = array_slice($titles, -2);

                        // Concatenate titles with the separator
                        $resultString = implode(' - ', $titlesToConcatenate);

                        // Output the result
                        return $resultString;
                    })->wrap(),
                Tables\Columns\TextColumn::make('parameter.hasil_kerja')
                    ->sortable()
                    ->label('Hasil Kerja')
                    ->wrap()
                    ->description(fn (Penilaian $penilaian) => 'Angka Kredit: ' . str_replace('.', ',', (((float)$penilaian->parameter->angka_kredit < 1) ? rtrim(rtrim($penilaian->parameter->angka_kredit, '0'), '.') : (string)rtrim(rtrim(number_format((float)$penilaian->parameter->angka_kredit, 2, '.', ''), '0'), '.')))),
                Tables\Columns\TextColumn::make('nilai')
                    ->label('Kuantitas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->formatStateUsing(fn ($state) => (explode('.', $state)[1] ?? 'file'))
                    ->url(fn ($state) => env('APP_URL') . "/storage/" . $state, true), //(fn (Penilaian $record) => env('APP_URL'). "storage/" . $record->file),
                Tables\Columns\IconColumn::make('approval')
                    ->label('Verifikasi')
                    ->boolean()
                    ->sortable()
                    ->action(function ($record, $column, Penilaian $penilaian) {
                        $name = $column->getName();
                        if ($penilaian->file && $penilaian->nilai && ((auth()->user()->id === $penilaian->parameter->parent->id ?? false) || auth()->user()->hasRole(['super_admin', 'verifikator_pusat', 'verifikator_unit']))) {
                            $record->update([
                                $name => !$record->$name
                            ]);

                            if ($record->$name) {
                                $penilaian->update([
                                    'jumlah' => (float)$penilaian->nilai * (float)$penilaian->parameter->angka_kredit,
                                    'komentar' => null
                                ]);
                            } else {
                                $penilaian->update([
                                    'jumlah' => null
                                ]);
                            }
                        }
                    }),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Nilai'),
                /* Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), */
            ])
            ->filters([
                /* SelectFilter::make('pegawai')
                    ->relationship('user', 'name', fn (Builder $query) => $query->where('id', auth()->user()->id)->orWhere('id', User::find(auth()->user()->id)->children->id ?? auth()->user()->id))
                    ->default(fn () => auth()->user()->id), */
                Filter::make('ppak')
                    ->form([
                        Forms\Components\Grid::make()
                            ->columns([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])->schema([
                                Forms\Components\Select::make('periode_filter')
                                    ->label('Pilih Periode')
                                    ->options(fn () => Cache::rememberForever('periodes_nama_id', function () {
                                        return Periode::all()->pluck('nama', 'id');
                                    }))
                                    ->preload()
                                    ->default(fn () => Periode::where('is_active', true)->first()->id ?? null)
                                    ->disabled(!auth()->user()->hasRole(['super_admin']))
                                    ->live(),
                                Forms\Components\Select::make('unit_filter')
                                    ->label('Pilih Unit')
                                    ->columnSpan(1)
                                    ->options(fn () => Cache::rememberForever('units_nama_id', function () {
                                        return Unit::all()->pluck('nama', 'id');
                                    }))
                                    ->searchable()
                                    ->preload(auth()->user()->hasRole(['super_admin', 'verifikator_pusat']))
                                    ->default(fn () => auth()->user()->unit_id)
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $users_all = Cache::rememberForever('users_all', function () {
                                            return User::all();
                                        });
                                        //$set('pegawai_filter', $users_all->where('unit_id', $state)->first()->id ?? null);
                                    })
                                    ->live()
                                    ->disabled(!auth()->user()->hasRole(['super_admin', 'verifikator_pusat'])),
                            ]),

                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $unitId = $data['unit_filter'];
                        return $query->where('periode_id', $data['periode_filter'])->whereHas('user.unit', function ($query) use ($unitId) {
                            $query->where('units.id', $unitId);
                        });
                    })
,
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(1)
            //->persistFiltersInSession(true)
            
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->recordUrl(
                null
            )
            ->recordAction(fn () => null)
            ->recordUrl(fn () => null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFastModes::route('/'),
        ];
    }
}
