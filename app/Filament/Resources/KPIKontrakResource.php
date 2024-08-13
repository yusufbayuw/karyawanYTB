<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\KPIKontrak;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KPIKontrakResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\KPIKontrakResource\RelationManagers;
use App\Models\KPIPenilaian;

class KPIKontrakResource extends Resource
{
    protected static ?string $model = KPIKontrak::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $modelLabel = 'Master Kontrak';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Master Kontrak';

    protected static ?string $slug = 'kpi-master-kontrak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('periode_kpi_id')
                    ->relationship('periode', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Periode'),
                Forms\Components\Select::make('unit_kpi_id')
                    ->relationship('unit_kpi', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Unit'),
                Forms\Components\TextInput::make('job_code')
                    ->label('Job Code'),
                Forms\Components\TextInput::make('order')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kpi')
                    ->label('KPI')
                    ->maxLength(255),
                Forms\Components\TextInput::make('currency')
                    ->maxLength(255),
                Forms\Components\TextInput::make('poin')
                    ->maxLength(255),
                Forms\Components\Repeater::make('terusan')
                    ->label('Terusan Penilaian Ke-')
                    ->schema([
                        Forms\Components\Select::make('kontrak')
                            ->label('Kontrak')
                            ->options(fn (KPIKontrak $kPIKontrak) => KPIKontrak::where('periode_kpi_id', $kPIKontrak->periode_kpi_id)->pluck('kpi_code', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                // Forms\Components\Select::make('parent_id')
                //     ->options(KPIKontrak::all()->pluck('kpi_code', 'id'))
                //     ->searchable()
                //     ->preload()
                //     ->label('Teruskan Ke-'),
                Forms\Components\Toggle::make('is_kepanitiaan')
                    ->label('Poin Kepanitiaan?'),
                Forms\Components\Toggle::make('is_kejuaraan')
                    ->label('Poin Kejuaraan?'),
                Forms\Components\Toggle::make('is_komponen_pengurang')
                    ->label('Poin Pengurang?'),
                Forms\Components\Toggle::make('is_cabang_pengurang')
                    ->label('Poin Pengurang?'),
                Forms\Components\Toggle::make('is_persentase')
                    ->label('Rumus Persentase?'),
                Forms\Components\Toggle::make('is_pengali')
                    ->label('Rumus Pengali?'),
                Forms\Components\Toggle::make('is_static')
                    ->label('Nilai Static?'),
                Forms\Components\Toggle::make('is_bulan')
                    ->label('Rumus Bulan?'),
                Forms\Components\Toggle::make('is_jp')
                    ->label('Jam Pertemuan?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('periode.nama')
                    ->label('Periode')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('unit_kpi.code')
                    ->label('Unit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('job_code')
                    ->label('Job Code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kpi')
                    ->label('KPI')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kpi_code')
                    ->label('KPI (Code)')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('target')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('terusan.code')
                    ->label('Terusan')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_kepanitiaan')
                    ->boolean()->sortable()
                    ->label('Kepanitiaan')
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_kejuaraan')
                    ->boolean()->sortable()
                    ->label('Prestasi Siswa')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_komponen_pengurang')
                    ->boolean()->sortable()
                    ->label('Kepatuhan Pengurang')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_cabang_pengurang')
                    ->boolean()->sortable()
                    ->label('Cabang Pengurang')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_persentase')
                    ->boolean()->sortable()
                    ->label('Rumus Persentase')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_pengali')
                    ->boolean()->sortable()
                    ->label('Rumus Pengali')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_static')
                    ->boolean()->sortable()
                    ->label('Nilai Static')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_bulan')
                    ->boolean()->sortable()
                    ->label('Rumus Bulan')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_jp')
                    ->boolean()->sortable()
                    ->label('Jam Pertemuan')
                    ->wrapHeader()
                    ->alignCenter()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    })
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
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
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKPIKontraks::route('/'),
            'create' => Pages\CreateKPIKontrak::route('/create'),
            'edit' => Pages\EditKPIKontrak::route('/{record}/edit'),
        ];
    }
}
