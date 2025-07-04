<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PensiunResource\Pages;
use App\Filament\Resources\PensiunResource\RelationManagers;
use App\Models\Pensiun;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PensiunResource extends Resource
{
    protected static ?string $model = Pensiun::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $modelLabel = 'Pensiun Pegawai';
    protected static ?string $navigationGroup = 'Benefit Pegawai';
    protected static ?string $navigationLabel = 'Pensiun Pegawai';
    protected static ?string $slug = 'pensiun-pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_pensiun'),
                Forms\Components\TextInput::make('nominal')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->tooltip(fn ($record) => 
                        'Tanggal Lahir: ' . (
                            $record->user && $record->user->tanggal_lahir
                                ? $record->user->tanggal_lahir->format('d M Y')
                                : '-'
                        ) . '. ' .
                        'Usia Pensiun Golongan ' . (
                            $record->user && $record->user->golongan && $record->user->golongan->nama
                                ? $record->user->golongan->nama
                                : '-'
                        ) . ' : ' . (
                            $record->user && $record->user->golongan && $record->user->golongan->usia_pensiun
                                ? $record->user->golongan->usia_pensiun
                                : '-'
                        ) . ' tahun'
                    )
                    ->label('Nama Pegawai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pensiun')
                    ->date('d M Y')
                    ->sortable(),
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
            'index' => Pages\ListPensiuns::route('/'),
            'create' => Pages\CreatePensiun::route('/create'),
            'view' => Pages\ViewPensiun::route('/{record}'),
            'edit' => Pages\EditPensiun::route('/{record}/edit'),
        ];
    }
}
