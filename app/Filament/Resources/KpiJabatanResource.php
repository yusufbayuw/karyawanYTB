<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiJabatanResource\Pages;
use App\Filament\Resources\KpiJabatanResource\RelationManagers;
use App\Models\KpiJabatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KpiJabatanResource extends Resource
{
    protected static ?string $model = KpiJabatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $modelLabel = 'Poin Tugas';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 15;

    protected static ?string $navigationLabel = 'Poin Tugas';

    protected static ?string $slug = 'kpi-poin-jabatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('poin')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
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
            'index' => Pages\ListKpiJabatans::route('/'),
            'create' => Pages\CreateKpiJabatan::route('/create'),
            'edit' => Pages\EditKpiJabatan::route('/{record}/edit'),
        ];
    }
}
