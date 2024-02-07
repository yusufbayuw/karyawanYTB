<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriPenilaianResource\Pages;
use App\Models\KategoriPenilaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class KategoriPenilaianResource extends Resource
{
    protected static ?string $model = KategoriPenilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $modelLabel = 'Kategori';

    protected static ?string $navigationGroup = 'Angka Kredit';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Kategori';

    protected static ?string $slug = 'angka-kredit-kategori';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
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
            'index' => Pages\ListKategoriPenilaians::route('/'),
            'create' => Pages\CreateKategoriPenilaian::route('/create'),
            'edit' => Pages\EditKategoriPenilaian::route('/{record}/edit'),
        ];
    }
}
