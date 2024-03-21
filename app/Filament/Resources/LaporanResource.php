<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Laporan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LaporanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LaporanResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class LaporanResource extends Resource
{
    protected static ?string $model = Laporan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Angka Kredit';

    protected static ?int $navigationSort = 13;

    protected static ?string $slug = 'angka-kredit-laporan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                /* Forms\Components\Select::make('periode_id')
                    ->relationship('periode', 'id')
                    ->default(null),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('unverified')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('revision')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('verified')
                    ->numeric()
                    ->default(null), */]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('periode.nama')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pegawai')
                    ->url(fn (Laporan $laporan) => "https://ppak.tarunabakti.or.id/angka-kredit-penilaian?tableFilters[ppak][periode_filter]=".$laporan->periode_id."&tableFilters[ppak][unit_filter]=".$laporan->user->unit->id."&tableFilters[ppak][pegawai_filter]=".$laporan->user->id."&tableFilters[ppak][kategori_filter]=1", true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.unit.nama')
                    ->label('Unit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unverified')
                    ->numeric()
                    /* ->default(
                        function (Laporan $laporan) {
                            $penilaians = Penilaian::where('periode_id', $laporan->periode_id)
                                ->where('user_id', $laporan->user_id)
                                ->whereNotNull('file')
                                ->whereNull('komentar')
                                ->where('approval', false)
                                ->select('id', 'nilai')
                                ->count();

                            return $penilaians;
                        }
                    ) */
                    ->badge(fn ($state) => $state > 0 ? true : false)
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('revision')
                    ->numeric()
                    /* ->default(
                        function (Laporan $laporan) {
                            $penilaians = Penilaian::where('periode_id', $laporan->periode_id)
                                ->where('user_id', $laporan->user_id)
                                ->whereNotNull('file')
                                ->whereNotNull('komentar')
                                ->where('approval', false)
                                ->select('id', 'nilai')
                                ->count();

                            return $penilaians;
                        }
                    ) */
                    ->badge(fn ($state) => $state > 0 ? true : false)
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('verified')
                    ->numeric()
                    /* ->default(
                        function (Laporan $laporan) {
                            $penilaians = Penilaian::where('periode_id', $laporan->periode_id)
                                ->where('user_id', $laporan->user_id)
                                ->whereNotNull('file')
                                ->whereNull('komentar')
                                ->where('approval', true)
                                ->select('id', 'nilai')
                                ->count();

                            return $penilaians;
                        }
                    ) */
                    ->badge(fn ($state) => $state > 0 ? true : false)
                    ->alignCenter()
                    ->sortable(),
                /* Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), */
            ])
            ->filters([
                SelectFilter::make('Unit')
                    ->relationship('user.unit', 'nama')
                    ->default(auth()->user()->unit->id)
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                //Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLaporans::route('/'),
            //'create' => Pages\CreateLaporan::route('/create'),
            //'edit' => Pages\EditLaporan::route('/{record}/edit'),
        ];
    }
}
