<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KPIPenilaianResource\Pages;
use App\Filament\Resources\KPIPenilaianResource\RelationManagers;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->relationship('user', 'name'),
                Forms\Components\TextInput::make('kpi_kontrak_id')
                    ->numeric(),
                Forms\Components\TextInput::make('kpi_periode_id')
                    ->numeric(),
                Forms\Components\TextInput::make('realisasi')
                    ->numeric(),
                Forms\Components\TextInput::make('total_realisasi')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kpi_kontrak_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kpi_periode_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('realisasi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_realisasi')
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
