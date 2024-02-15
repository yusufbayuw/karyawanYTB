<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KPIPeriodeResource\Pages;
use App\Filament\Resources\KPIPeriodeResource\RelationManagers;
use App\Models\KPIPeriode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KPIPeriodeResource extends Resource
{
    protected static ?string $model = KPIPeriode::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $modelLabel = 'Periode';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Periode';

    protected static ?string $slug = 'kpi-periode';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_mulai'),
                Forms\Components\DatePicker::make('tgl_selesai'),
                Forms\Components\Toggle::make('is_active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
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
            'index' => Pages\ListKPIPeriodes::route('/'),
            'create' => Pages\CreateKPIPeriode::route('/create'),
            'edit' => Pages\EditKPIPeriode::route('/{record}/edit'),
        ];
    }
}
