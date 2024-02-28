<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KPIFlowResource\Pages;
use App\Filament\Resources\KPIFlowResource\RelationManagers;
use App\Models\Jabatan;
use App\Models\KPIFlow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KPIFlowResource extends Resource
{
    protected static ?string $model = KPIFlow::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $modelLabel = 'Flow';

    protected static ?string $navigationGroup = 'KPI';

    protected static ?int $navigationSort = 21;

    protected static ?string $navigationLabel = 'Flow';

    protected static ?string $slug = 'kpi-flow';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('urutan')
                    ->schema([
                        Forms\Components\Select::make('jabatan')
                            ->options(fn () => Jabatan::all()->pluck('title', 'id'))
                            ->searchable()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),
                    ]),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
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
            'index' => Pages\ListKPIFlows::route('/'),
            'create' => Pages\CreateKPIFlow::route('/create'),
            'edit' => Pages\EditKPIFlow::route('/{record}/edit'),
        ];
    }
}
