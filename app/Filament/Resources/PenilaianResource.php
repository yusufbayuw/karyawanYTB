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
use Filament\Resources\Resource;
use App\Models\KategoriPenilaian;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Illuminate\Support\Facades\Cache;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\PenilaianResource\Pages;


class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;

    protected static int $maxDepth = 7;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $modelLabel = 'Penilaian';

    protected static ?string $navigationGroup = 'Angka Kredit';

    protected static ?int $navigationSort = 12;

    protected static ?string $navigationLabel = 'Penilaian';

    protected static ?string $slug = 'angka-kredit-penilaian';

    /* public static function getEloquentQuery(): Builder
    {
        $userAuth = auth()->user();
        if ($userAuth->hasRole(['super_admin'])) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('user_id', $userAuth->id)->orWhereIn('user_id', (User::whereIn('jabatan_id', (auth()->user()->jabatan->children->pluck('id')->toArray() ?? null))->pluck('id')->toArray() ?? null));
        }
    } */


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
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('file')
                    ->label('Unggah Berkas')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),
                Forms\Components\Toggle::make('approval')
                    ->label('Status Verifikasi')
                    ->disabled(fn () => !(auth()->user()->hasRole(['super_admin', 'verifikator_pusat', 'verifikator_unit'])))
                    ->afterStateUpdated(function ($state, Penilaian $penilaian, Set $set) {
                        if ($state) {
                            $set('jumlah', ($penilaian->parameter->angka_kredit ?? 0) * ($penilaian->nilai ?? 0));
                        } else {
                            $set('jumlah', null);
                        }
                    }),
                Forms\Components\Hidden::make('jumlah'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /* Tables\Columns\TextColumn::make('user.name')
                    ->label('Pegawai')
                    ->sortable()
                    ->description(fn (Penilaian $penilaian) => $penilaian->user->unit->nama . ' - ' . $penilaian->user->jabatan->title . ' - ' . $penilaian->user->golongan->nama)
                    ->wrap(), */
                Tables\Columns\TextColumn::make('parameter_id')
                    ->sortable()
                    ->label('Parameter')
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
                    ->description(fn (Penilaian $penilaian) => 'Angka Kredit: ' . str_replace('.', ',', $penilaian->parameter->angka_kredit)),
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
                                    'jumlah' => (float)$penilaian->nilai * (float)$penilaian->parameter->angka_kredit
                                ]);
                            } else {
                                $penilaian->update([
                                    'jumlah' => null
                                ]);
                            }
                        }
                    }),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Nilai')
                    ->summarize(Sum::make()->label('')),
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
                                    ->options(fn () => Cache::remember('periodes_nama_id', 30 * 60, function () {
                                        return Periode::all()->pluck('nama', 'id');
                                    }))
                                    ->default(fn () => Periode::where('is_active', true)->first()->id ?? null)
                                    ->disabled(!auth()->user()->hasRole(['super_admin']))
                                    ->live(),
                                Forms\Components\Select::make('unit_filter')
                                    ->label('Pilih Unit')
                                    ->options(fn () => Cache::remember('units_nama_id', 30 * 60, function () {
                                        return Unit::all()->pluck('nama', 'id');
                                    }))
                                    ->default(fn () => auth()->user()->unit_id)
                                    ->live()
                                    ->disabled(!auth()->user()->hasRole(['super_admin', 'verifikator_pusat'])),
                                Forms\Components\Select::make('pegawai_filter')
                                    ->label('Pilih Karyawan')
                                    ->options(function (Get $get) {
                                        $users_all = Cache::remember('users_all', 30 * 60, function () {
                                            return User::all();
                                        });

                                        return $users_all->where('unit_id', $get('unit_filter'))->pluck('name', 'id');
                                    }) //(fn (Get $get) => User::where('id', auth()->user()->id)->orWhereIn('id', (User::whereIn('jabatan_id', (auth()->user()->jabatan->children->pluck('id')->toArray() ?? null))->pluck('id')->toArray() ?? null))->where('unit_id', $get('unit_filter') ?? 0)->pluck('name', 'id'))
                                    ->disabled(fn (Get $get) => ($get('pegawai_filter') == null) || !auth()->user()->hasRole(['super_admin', 'verifikator_pusat', 'verifikator_unit']))
                                    ->default(auth()->user()->id)
                                    ->live(),
                                Forms\Components\Select::make('kategori_filter')
                                    ->label('Pilih Kategori')
                                    ->options(fn (Get $get) => Cache::remember('kategories_name_id', 30 * 60, function () {
                                        return KategoriPenilaian::all()->pluck('nama', 'id');
                                    }))
                                    ->disabled(fn () => explode(' - ', auth()->user()->golongan->nama)[0] !== 'Pranata Komputer' || !auth()->user()->hasRole(['super_admin', 'verifikator_pusat']))
                                    ->default(fn () => KategoriPenilaian::orderBy('id', 'asc')->first()->id)
                                    ->live(),
                            ])->columnSpanFull(),

                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->where('periode_id', $data['periode_filter'])->where('user_id', $data['pegawai_filter'])->where('kategori_id', $data['kategori_filter']);
                    })
                    ->indicateUsing(function (array $data): ?array {
                        $indicators = [];
                        if (!$data['pegawai_filter'] || !$data['unit_filter'] || !$data['kategori_filter'] || !$data['periode_filter']) {
                            $indicators[] = Indicator::make('Data tidak ditemukan')->removable(false);
                        } else {
                            $pegawai = User::find($data['pegawai_filter']);
                            $indicators[] = Indicator::make(Unit::find($data['unit_filter'])->nama . ': ' . $pegawai->name . ' - ' . $pegawai->golongan->nama . ' ' . $pegawai->tingkat->title)->removable(false);
                        }

                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(1)
            ->persistFiltersInSession(true)
            ->deferFilters()
            ->groups([
                Group::make('user.name')
                    ->titlePrefixedWithLabel(false)
                    ->label('Pegawai'),
                Group::make('leluhur')
                    ->titlePrefixedWithLabel(false)
                    ->label('Unsur'),
            ])
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
            ->defaultGroup('leluhur')
            ->defaultPaginationPageOption('all')
            ->recordAction(fn () => null)
            ->recordUrl(fn () => null)
            ->groupingSettingsHidden()
            ->groupsOnly(fn () => auth()->user()->gruop_penilaian);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenilaians::route('/'),
        ];
    }
}
