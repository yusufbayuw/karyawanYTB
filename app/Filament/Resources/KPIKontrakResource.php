<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KPIKontrakResource\Pages;
use App\Filament\Resources\KPIKontrakResource\RelationManagers;
use App\Models\KPIKontrak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KPIKontrakResource extends Resource
{
    protected static ?string $model = KPIKontrak::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $modelLabel = 'Kontrak';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Kontrak';

    protected static ?string $slug = 'kpi-kontrak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('periode_kpi_id')
                    ->relationship('periode', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Periode'),
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Unit'),
                Forms\Components\Select::make('jabatan_id')
                    ->relationship('jabatan', 'title')
                    ->searchable()
                    ->preload()
                    ->label('Job Name'),
                Forms\Components\TextInput::make('order')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kpi')
                    ->label('KPI')
                    ->maxLength(255),
                Forms\Components\TextInput::make('currency')
                    ->maxLength(255),
                Forms\Components\TextInput::make('poin')
                    ->maxLength(255),
                Forms\Components\Select::make('parent_id')
                    ->options(KPIKontrak::all()->pluck('kpi_code', 'id'))
                    ->searchable()
                    ->preload()
                    ->label('Teruskan Ke-'),
                Forms\Components\Toggle::make('is_kepanitiaan')
                    ->required()
                    ->label('Poin Kepanitiaan?'),
                Forms\Components\Toggle::make('is_kejuaraan')
                    ->required()
                    ->label('Poin Kejuaraan?'),
                Forms\Components\Toggle::make('is_komponen_pengurang')
                    ->required()
                    ->label('Poin Pengurang?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('periode.nama')
                    ->label('Periode')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('unit.code')
                    ->label('Unit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jabatan.code')
                    ->label('Job Name')
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
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('terusan.code')
                    ->label('Terusan')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_kepanitiaan')
                    ->boolean()
                    ->label('Kepanitiaan'),
                Tables\Columns\IconColumn::make('is_kejuaraan')
                    ->boolean()
                    ->label('Kejuaraan'),
                Tables\Columns\IconColumn::make('is_komponen_pengurang')
                    ->boolean()
                    ->label('Pengurang'),
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
