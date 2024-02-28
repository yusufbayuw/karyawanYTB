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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Kontrak';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 22;

    protected static ?string $navigationLabel = 'Kontrak';

    protected static ?string $slug = 'kpi-kontrak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kpi_flow_id')
                    ->label('Flow')
                    ->relationship('flow', 'nama'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kuantitas')
                    ->numeric(),
                Forms\Components\TextInput::make('keterangan_kuantitas')
                    ->maxLength(255),
                Forms\Components\TextInput::make('total')
                    ->numeric(),
                Forms\Components\Toggle::make('komponen_pengurang')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flow.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kuantitas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan_kuantitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('komponen_pengurang')
                    ->boolean(),
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
