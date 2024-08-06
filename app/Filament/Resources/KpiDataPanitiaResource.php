<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\KPIPeriode;
use Filament\Tables\Table;
use App\Models\KpiSkPanitia;
use App\Models\KpiDataPanitia;
use App\Models\KpiKepanitiaan;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KpiDataPanitiaResource\Pages;
use App\Filament\Resources\KpiDataPanitiaResource\RelationManagers;

class KpiDataPanitiaResource extends Resource
{
    protected static ?string $model = KpiDataPanitia::class;

    protected static ?string $navigationIcon = 'heroicon-o-chevron-double-up';

    protected static ?string $modelLabel = 'Data Kepanitiaan';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 26;

    protected static ?string $navigationLabel = 'Data Kepanitiaan';

    protected static ?string $slug = 'kpi-data-kepanitiaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('periode_kpi_id')
                    ->default(fn () => KPIPeriode::where('is_active', true)->first()->id),
                Forms\Components\Select::make('user_id')
                    ->label('Nama Pegawai')
                    ->options(User::all()->pluck('name','id'))
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('sk_id')
                    ->label('Nama Kepanitiaan')
                    ->options(fn () => KpiSkPanitia::where('periode_kpi_id', KPIPeriode::where('is_active', true)->first()->id)->pluck('nama', 'id'))
                    ->live(),
                Forms\Components\Select::make('kpi_kepanitiaan_id')
                    ->label('Penugasan')
                    ->options(fn (Get $get) => KpiKepanitiaan::where('jenis', KpiSkPanitia::find($get('sk_id'))->jenis ?? null)->pluck('penugasan', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pegawai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode.nama')
                    ->label('Periode')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sk.nama')
                    ->label('Kepanitiaan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sk.jenis')
                    ->searchable()
                    ->label('Jenis')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepanitiaan.penugasan')
                    ->searchable()
                    ->label('Penugasan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kepanitiaan.poin')
                    ->label('Poin')
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
            'index' => Pages\ManageKpiDataPanitias::route('/'),
        ];
    }
}
