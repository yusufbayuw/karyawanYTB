<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\KPIPeriode;
use Filament\Tables\Table;
use App\Models\KpiDataPrestasi;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KpiDataPrestasiResource\Pages;
use App\Filament\Resources\KpiDataPrestasiResource\RelationManagers;
use App\Models\KpiKejuaraan;
use App\Models\User;
use Filament\Forms\Get;

class KpiDataPrestasiResource extends Resource
{
    protected static ?string $model = KpiDataPrestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $modelLabel = 'Data Prestasi Siswa';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 25;

    protected static ?string $navigationLabel = 'Data Prestasi Siswa';

    protected static ?string $slug = 'kpi-data-prestasi-siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('periode_kpi_id')
                    ->default(fn () => KPIPeriode::where('is_active', true)->first()->id),
                Forms\Components\Select::make('user_id')
                    ->label('Nama Pegawai')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->preload(),
                Forms\Components\TextInput::make('nama')
                    ->label('Ajang')
                    ->maxLength(255),
                Forms\Components\Select::make('kpi_kejuaraan_id')
                    ->label('Kualifikasi')
                    ->required()
                    ->options(KpiKejuaraan::all()->pluck('link', 'id'))
                    /* ->disabled(fn (Get $get) => $get('user_id') ? false : true)
                    ->options(function (Get $get) {
                        if ($get('user_id')) {
                            $jabatans = explode(',', User::find($get('user_id'))->jabatan->code ?? null);
                            $jabatanAcuan = KpiKejuaraan::distinct()->pluck('job_code');
    
                            $dataAcuan = [];
                            foreach ($jabatanAcuan as $acuan) {
                                foreach ($jabatans as $jabatan) {
                                    
                                    if (strpos($acuan,$jabatan) !== false) {
                                        $dataAcuan[] = $acuan; //$acuan . "-" . $jabatan . "-" . ((strpos($acuan,$jabatan) !== false) ? "1" : "0");
                                    }
                                    
                                }
                            }
                            return KpiKejuaraan::whereIn('job_code', array_unique($dataAcuan))->pluck('link', 'id');
                        } else {
                            return null;
                        }
                    }) 
                    ->searchable()
                    ->preload() */,
                Forms\Components\FileUpload::make('file'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pegawai')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kejuaraan.prestasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kejuaraan.poin')
                    ->numeric()
                    ->label('Poin')
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageKpiDataPrestasis::route('/'),
        ];
    }
}
