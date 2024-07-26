<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiKejuaraanResource\Pages;
use App\Filament\Resources\KpiKejuaraanResource\RelationManagers;
use App\Models\KpiKejuaraan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KpiKejuaraanResource extends Resource
{
    protected static ?string $model = KpiKejuaraan::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $modelLabel = 'Poin Prestasi';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 16;

    protected static ?string $navigationLabel = 'Poin Prestasi';

    protected static ?string $slug = 'kpi-poin-prestasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('prestasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kategori')
                    ->maxLength(255),
                Forms\Components\TextInput::make('poin')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prestasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('poin')
                    ->numeric()
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
            'index' => Pages\ListKpiKejuaraans::route('/'),
            'create' => Pages\CreateKpiKejuaraan::route('/create'),
            'edit' => Pages\EditKpiKejuaraan::route('/{record}/edit'),
        ];
    }
}
