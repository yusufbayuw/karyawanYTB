<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KPIPenilaianResource\Pages;
use App\Filament\Resources\KPIPenilaianResource\RelationManagers;
use App\Models\KpiKejuaraan;
use App\Models\KpiKepanitiaan;
use App\Models\KPIKontrak;
use App\Models\KPIPenilaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KPIPenilaianResource extends Resource
{
    protected static ?string $model = KPIPenilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $modelLabel = 'Penilaian';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 23;

    protected static ?string $navigationLabel = 'Penilaian';

    protected static ?string $slug = 'kpi-penilaian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('kpi_kontrak_id')
                    ->options(KPIKontrak::all()->pluck('kpi_code', 'id'))
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('target')
                    ->numeric(),
                Forms\Components\TextInput::make('realisasi')
                    ->numeric(),
                Forms\Components\TextInput::make('total')
                    ->numeric(),
                //Forms\Components\TextInput::make('total_realisasi')
                //    ->numeric(),
                Forms\Components\Repeater::make('rincian_kepanitiaan')
                    ->label('Rincian Kepanitiaan')
                    ->schema([
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn (KPIPenilaian $kPIPenilaian) => $kPIPenilaian->user_id),
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Kegiatan'),
                        Forms\Components\Select::make('kpi_kepanitiaan_id')
                            ->label('Posisi')
                            ->options(KpiKepanitiaan::all()->pluck('link', 'id'))
                            ->searchable()
                            ->preload(),
                    ])
                    ->columnSpanFull()
                    ->hidden(fn (KPIPenilaian $kPIPenilaian) => !$kPIPenilaian->kontrak->is_kepanitiaan),
                Forms\Components\Repeater::make('rincian_prestasi')
                    ->label('Rincian Prestasi Siswa')
                    ->schema([
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn (KPIPenilaian $kPIPenilaian) => $kPIPenilaian->user_id),
                        Forms\Components\TextInput::make('nama')
                            ->label('Ajang'),
                        Forms\Components\Select::make('kpi_kejuaraan_id')
                            ->label('Kualifikasi')
                            ->options(KpiKejuaraan::all()->pluck('link', 'id'))
                            ->searchable()
                            ->preload(),
                    ])
                    ->columnSpanFull()
                    ->hidden(fn (KPIPenilaian $kPIPenilaian) => !$kPIPenilaian->kontrak->is_kejuaraan),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kontrak.kpi_code')
                    ->searchable()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('target')
                    ->sortable(),
                Tables\Columns\TextInputColumn::make('realisasi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                /* Tables\Columns\TextColumn::make('total_realisasi')
                    ->numeric()
                    ->sortable(), */
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
            'index' => Pages\ManageKPIPenilaians::route('/'),
        ];
    }
}
