<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\KPIKontrak;
use App\Models\KPIPeriode;
use Filament\Tables\Table;
use App\Models\KpiKejuaraan;
use App\Models\KPIPenilaian;
use App\Models\KpiKepanitiaan;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Cache;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KPIPenilaianResource\Pages;
use App\Filament\Resources\KPIPenilaianResource\RelationManagers;
use App\Models\KpiDataPanitia;

class KPIPenilaianResource extends Resource
{
    protected static ?string $model = KPIPenilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $modelLabel = 'Kontrak Pegawai';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 23;

    protected static ?string $navigationLabel = 'Kontrak Pegawai';

    protected static ?string $slug = 'kpi-kontrak-pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Pegawai')
                    ->disabled()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('kpi_kontrak_id')
                    ->options(KPIKontrak::all()->pluck('kpi_code', 'id'))
                    ->label('KPI')
                    ->disabled()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('target')
                    ->numeric()
                    ->suffix(fn (KPIPenilaian $kPIPenilaian) => ' ' . $kPIPenilaian->kontrak->currency)
                    ->readOnly(),
                Forms\Components\TextInput::make('realisasi')
                    ->numeric(),
                //Forms\Components\TextInput::make('total')
                //    ->numeric(),
                //Forms\Components\TextInput::make('total_realisasi')
                //    ->numeric(),
                Forms\Components\Repeater::make('rincian_kepanitiaan')
                    ->label('Rincian Kepanitiaan')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Kegiatan')
                            ->readOnly(),
                        Forms\Components\TextInput::make('jenis')
                            ->columnSpan(1)
                            ->readOnly(),
                        Forms\Components\TextInput::make('penugasan')
                            ->readOnly(),
                        Forms\Components\TextInput::make('poin')
                            ->readOnly(),
                    ])
                    ->columns(4)
                    ->reorderable(false)
                    ->addable(false)
                    ->deletable(false)
                    ->columnSpanFull()
                    ->hidden(fn (KPIPenilaian $kPIPenilaian) => !$kPIPenilaian->kontrak->is_kepanitiaan),
                Forms\Components\Repeater::make('rincian_prestasi')
                    ->label('Rincian Prestasi Siswa')
                    ->schema([
                        Forms\Components\TextInput::make('ajang')
                            ->readOnly(),
                        Forms\Components\TextInput::make('jabatan')
                            ->readOnly(),
                        Forms\Components\TextInput::make('kategori')
                            ->readOnly(),
                        Forms\Components\TextInput::make('poin')
                            ->readOnly(),
                        /* Forms\Components\TextInput::make('file')
                            ->readOnly(), */
                    ])
                    ->columnSpanFull()
                    ->columns(4)
                    ->reorderable(false)
                    ->addable(false)
                    ->deletable(false)
                    ->hidden(fn (KPIPenilaian $kPIPenilaian) => !$kPIPenilaian->kontrak->is_kejuaraan),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Tables\Columns\TextColumn::make('user.name')
                //    ->label('Pegawai')
                //    ->wrap()
                //    ->sortable(),
                Tables\Columns\TextColumn::make('kontrak.kpi_code')
                    ->label('KPI')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target')
                    ->alignRight()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kontrak.currency')
                    ->label('Kuantitas')
                    ->wrap(),
                Tables\Columns\TextColumn::make('kontrak.poin')
                    ->label('Poin')
                    ->alignRight()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Jumlah Poin')
                    ->alignRight()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('realisasi')
                    ->sortable()
                    ->disabled(function (KPIPenilaian $kPIPenilaian) {
                        
                        dd(KPIKontrak::whereJsonContains('terusan', ['kontrak' => "{$kPIPenilaian->kontrak->id}"])->get());
                        if ($kPIPenilaian->kontrak->is_kepanitiaan || $kPIPenilaian->kontrak->is_kejuaraan) {
                            //kasus kejuaraan
                            return true;
                        } elseif ($kPIPenilaian->user->jabatan->children->count() && ($kPIPenilaian->kontrak->children ?? 0)) {
                            // kasus jabatan membawahi dan kontrak memiliki children, kasus tidak membawahi namun kontrak memiliki children dan jabatan atasan berbeda, 
                            return true;
                        } else {
                            return false;
                        }
                    } )
                    ->alignRight(),
                Tables\Columns\TextColumn::make('kontrak.id')
                    ->formatStateUsing(fn (KPIPenilaian $kPIPenilaian) => $kPIPenilaian->kontrak->currency)
                    ->label('Kuantitas')
                    ->wrap(),
                Tables\Columns\TextColumn::make('total_realisasi')
                    ->label('Jumlah Poin')
                    ->alignRight()
                    ->formatStateUsing(fn ($state) => ($state < 0) ? '(' . abs($state) . ')' : $state)
                    ->color(fn ($state) => ($state < 0) ? 'danger' : '')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('kpi')
                    ->form([
                        Forms\Components\Grid::make()
                            ->columns([
                                'sm' => 2,
                                'xl' => 4,
                                '2xl' => 4,
                            ])->schema([
                                Forms\Components\Select::make('periode_filter')
                                    ->label('Pilih Periode')
                                    ->options(fn () => Cache::rememberForever('periodes_kpi_nama_id', function () {
                                        return KPIPeriode::all()->pluck('nama', 'id');
                                    }))
                                    ->preload()
                                    ->default(fn () => KPIPeriode::where('is_active', true)->first()->id ?? null)
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
                                        $set('pegawai_filter', $users_all->where('unit_id', $state)->first()->id ?? null);
                                    })
                                    ->live()
                                    ->disabled(!auth()->user()->hasRole(['super_admin', 'verifikator_pusat'])),
                                Forms\Components\Select::make('pegawai_filter')
                                    ->label('Pilih Karyawan')
                                    ->options(function (Get $get) {
                                        $users_all = Cache::rememberForever('users_all', function () {
                                            return User::all();
                                        });

                                        return $users_all->where('unit_id', $get('unit_filter'))->pluck('name', 'id');
                                    }) //(fn (Get $get) => User::where('id', auth()->user()->id)->orWhereIn('id', (User::whereIn('jabatan_id', (auth()->user()->jabatan->children->pluck('id')->toArray() ?? null))->pluck('id')->toArray() ?? null))->where('unit_id', $get('unit_filter') ?? 0)->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload(auth()->user()->hasRole(['super_admin', 'verifikator_pusat', 'verifikator_unit']))
                                    ->disabled(fn (Get $get) => ($get('pegawai_filter') == null) || !auth()->user()->hasRole(['super_admin', 'verifikator_pusat', 'verifikator_unit']))
                                    ->default(auth()->user()->id)
                                    ->live(),
                            ]),

                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->where('periode_kpi_id', $data['periode_filter'])->where('user_id', $data['pegawai_filter']);
                    })
                    ->indicateUsing(function (array $data): ?array {
                        $indicators = [];
                        if (!$data['pegawai_filter'] || !$data['unit_filter'] || !$data['periode_filter']) {
                            $indicators[] = Indicator::make('Data tidak ditemukan')->removable(false);
                        } else {
                            $pegawai = User::find($data['pegawai_filter']);
                            $indicators[] = Indicator::make(Unit::find($data['unit_filter'])->nama . ': ' . $pegawai->name . ' - ' . $pegawai->jabatan->title)->removable(false);
                        }

                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(1)
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption('all');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageKPIPenilaians::route('/'),
        ];
    }
}
