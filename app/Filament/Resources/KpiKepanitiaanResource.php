<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiKepanitiaanResource\Pages;
use App\Filament\Resources\KpiKepanitiaanResource\RelationManagers;
use App\Models\KpiKepanitiaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KpiKepanitiaanResource extends Resource
{
    protected static ?string $model = KpiKepanitiaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-chevron-double-up';

    protected static ?string $modelLabel = 'Poin Kepanitiaan';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 17;

    protected static ?string $navigationLabel = 'Poin Kepanitiaan';

    protected static ?string $slug = 'kpi-poin-kepanitiaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jenis')
                    ->maxLength(255),
                Forms\Components\TextInput::make('penugasan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('poin')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penugasan')
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
            'index' => Pages\ListKpiKepanitiaans::route('/'),
            'create' => Pages\CreateKpiKepanitiaan::route('/create'),
            'edit' => Pages\EditKpiKepanitiaan::route('/{record}/edit'),
        ];
    }
}
