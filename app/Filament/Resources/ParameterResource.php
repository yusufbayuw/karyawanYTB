<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParameterResource\Pages;
use App\Filament\Resources\ParameterResource\RelationManagers;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParameterResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('golongan_id')
                    ->relationship('golongan', 'nama'),
                Forms\Components\TextInput::make('unsur')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sub_unsur')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('uraian_1')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('uraian_2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('uraian_3')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('hasil_kerja')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('angka_kredit')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('golongan.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unsur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_unsur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uraian_1')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uraian_2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uraian_3')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hasil_kerja')
                    ->searchable(),
                Tables\Columns\TextColumn::make('angka_kredit')
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
            'index' => Pages\ListParameters::route('/'),
            'create' => Pages\CreateParameter::route('/create'),
            'edit' => Pages\EditParameter::route('/{record}/edit'),
        ];
    }
}
