<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GajiPegawaiResource\Pages;
use App\Filament\Resources\GajiPegawaiResource\RelationManagers;
use App\Models\GajiPegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GajiPegawaiResource extends Resource
{
    protected static ?string $model = GajiPegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $modelLabel = 'Gaji Pegawai';
    protected static ?string $navigationGroup = 'Benefit Pegawai';
    protected static ?string $navigationLabel = 'Gaji Pegawai';
    protected static ?string $slug = 'gaji-pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Nama Pegawai')
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Pegawai')
                    ->required(),
                Forms\Components\TextInput::make('tahun')
                    ->numeric()
                    ->required()
                    ->placeholder('Tahun Gaji, contoh: 2023'),
                Forms\Components\TextInput::make('nominal')
                    ->numeric()
                    ->label('Nominal Gaji')
                    ->placeholder('Masukkan nominal gaji')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pegawai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\TextColumn::make('nominal')
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
            'index' => Pages\ListGajiPegawais::route('/'),
            'create' => Pages\CreateGajiPegawai::route('/create'),
            'view' => Pages\ViewGajiPegawai::route('/{record}'),
            'edit' => Pages\EditGajiPegawai::route('/{record}/edit'),
        ];
    }
}
