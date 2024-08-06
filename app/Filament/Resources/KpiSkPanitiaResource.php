<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KpiSkPanitiaResource\Pages;
use App\Filament\Resources\KpiSkPanitiaResource\RelationManagers;
use App\Models\KpiKepanitiaan;
use App\Models\KPIPeriode;
use App\Models\KpiSkPanitia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KpiSkPanitiaResource extends Resource
{
    protected static ?string $model = KpiSkPanitia::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'SK Kepanitiaan';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 21;

    protected static ?string $navigationLabel = 'SK Kepanitiaan';

    protected static ?string $slug = 'kpi-sk-kepanitiaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('periode_kpi_id')
                    ->default(fn () => KPIPeriode::where('is_active', true)->first()->id),
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor')
                    ->maxLength(255),
                Forms\Components\Select::make('jenis')
                    ->options(fn () => KpiKepanitiaan::distinct()->pluck('jenis', 'jenis')),
                Forms\Components\FileUpload::make('file'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('periode.nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file')
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
            'index' => Pages\ManageKpiSkPanitias::route('/'),
        ];
    }
}
