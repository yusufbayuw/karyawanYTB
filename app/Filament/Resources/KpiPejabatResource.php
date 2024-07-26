<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiPejabatResource\Pages;
use App\Filament\Resources\KpiPejabatResource\RelationManagers;
use App\Models\KpiPejabat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KpiPejabatResource extends Resource
{
    protected static ?string $model = KpiPejabat::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $modelLabel = 'Jabatan';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 21;

    protected static ?string $navigationLabel = 'Jabatan';

    protected static ?string $slug = 'kpi-jabatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
                Forms\Components\TextInput::make('kpi_jabatan_id')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kpi_jabatan_id')
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
            'index' => Pages\ListKpiPejabats::route('/'),
            'create' => Pages\CreateKpiPejabat::route('/create'),
            'edit' => Pages\EditKpiPejabat::route('/{record}/edit'),
        ];
    }
}
