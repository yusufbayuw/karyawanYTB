<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\KPIPenilaian;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KPIPenilaianResource\Pages;
use App\Filament\Resources\KPIPenilaianResource\RelationManagers;

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
                Forms\Components\Select::make('kpi_kontrak_id')
                    ->relationship('kontrak', 'nama')
                    ->searchable(),
                Forms\Components\Select::make('kpi_periode_id')
                    ->relationship('periode', 'nama'),
                Forms\Components\TextInput::make('realisasi')
                    ->numeric()
                    ,
                Forms\Components\TextInput::make('total_realisasi')
                    ->numeric()
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kontrak.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode.nama')
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
