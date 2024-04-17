<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Golongan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\GolonganResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\GolonganResource\RelationManagers;

class GolonganResource extends Resource
{
    protected static ?string $model = Golongan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';

    protected static ?string $modelLabel = 'Golongan';

    protected static ?string $navigationGroup = 'Pegawai';

    protected static ?string $navigationLabel = 'Golongan';

    protected static ?string $slug = 'pegawai-golongan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file')
                    ->label('Unggah File Acuan AK')
                    ->acceptedFileTypes(['image/jpeg','image/png','image/webp']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('file')
                    ->simpleLightbox(),
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
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->recordAction(fn () => null)
            ->recordUrl(fn () => null);
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
            'index' => Pages\ListGolongans::route('/'),
            'create' => Pages\CreateGolongan::route('/create'),
            'edit' => Pages\EditGolongan::route('/{record}/edit'),
        ];
    }
}
