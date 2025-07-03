<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PremiResource\Pages;
use App\Filament\Resources\PremiResource\RelationManagers;
use App\Models\Premi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PremiResource extends Resource
{
    protected static ?string $model = Premi::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $modelLabel = 'Premi Pegawai';
    protected static ?string $navigationGroup = 'Benefit Pegawai';
    protected static ?string $navigationLabel = 'Premi Pegawai';
    protected static ?string $slug = 'premi-pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_premi'),
                Forms\Components\TextInput::make('persentase')
                    ->numeric(),
                Forms\Components\TextInput::make('nominal')
                    ->numeric(),
                Forms\Components\TextInput::make('keterangan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_premi')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('persentase')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPremis::route('/'),
            'create' => Pages\CreatePremi::route('/create'),
            'view' => Pages\ViewPremi::route('/{record}'),
            'edit' => Pages\EditPremi::route('/{record}/edit'),
        ];
    }
}
