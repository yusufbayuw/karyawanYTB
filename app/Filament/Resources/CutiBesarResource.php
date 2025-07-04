<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CutiBesarResource\Pages;
use App\Filament\Resources\CutiBesarResource\RelationManagers;
use App\Models\CutiBesar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CutiBesarResource extends Resource
{
    protected static ?string $model = CutiBesar::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $modelLabel = 'Cuti Besar';
    protected static ?string $navigationGroup = 'Benefit Pegawai';
    protected static ?string $navigationLabel = 'Cuti Besar';
    protected static ?string $slug = 'cuti-besar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_pengajuan'),
                Forms\Components\TextInput::make('berkas_pengajuan')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_realisasi_1'),
                Forms\Components\DatePicker::make('tanggal_realisasi_2'),
                Forms\Components\TextInput::make('nominal_kompensasi')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pegawai')
                    ->tooltip(fn ($record) => 'Tanggal SK Tetap: ' . optional($record->user?->tanggal_sk_pegawai_tetap)->format('d M Y'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('berkas_pengajuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_realisasi_1')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_realisasi_2')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nominal_kompensasi')
                    ->numeric()
                    ->money('IDR', true)
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
            'index' => Pages\ListCutiBesars::route('/'),
            'create' => Pages\CreateCutiBesar::route('/create'),
            'view' => Pages\ViewCutiBesar::route('/{record}'),
            'edit' => Pages\EditCutiBesar::route('/{record}/edit'),
        ];
    }
}
