<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianResource\Pages;
use App\Filament\Resources\PenilaianResource\RelationManagers;
use App\Models\Penilaian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;

    protected static int $maxDepth = 7;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $modelLabel = 'Penilaian Kredit';

    protected static ?string $navigationGroup = 'Angka Kredit';

    protected static ?int $navigationSort = 12;

    protected static ?string $navigationLabel = 'Penilaian Kredit';

    protected static ?string $slug = 'penilaian-kredit';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                Forms\Components\Select::make('parameter_id')
                    ->relationship('parameter', 'title')
                    ->disabled(),
                Forms\Components\TextInput::make('nilai')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('file')
                    ->required(),
                Forms\Components\Toggle::make('approval')
                    ->disabled(fn (Penilaian $penilaian) => !(auth()->user()->jabatan_id === $penilaian->user->jabatan->parent->id)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('parameter_id')
                    ->sortable()
                    ->label('Parameter')
                    ->formatStateUsing(function (Penilaian $penilaian) {
                        // Convert JSON to an associative array
                        $data = json_decode($penilaian->parameter->ancestors, true);
                        
                        // Extract titles
                        $titles = array_column($data, 'title');
                        
                        // Exclude the last two titles
                        $titlesToConcatenate = array_slice($titles, 0, -2);

                        // Concatenate titles with the separator
                        $resultString = implode(' - ', $titlesToConcatenate);

                        if ($resultString) {
                            $resultString = $resultString . ' - ' . $penilaian->parameter->title;
                        } else {
                            $resultString = $penilaian->parameter->title;
                        }
                        // Output the result
                        return $resultString;
                    })
                    ->description(function (Penilaian $penilaian) {
                        // Convert JSON to an associative array
                        $data = json_decode($penilaian->parameter->ancestors, true);
                        
                        // Extract titles
                        $titles = array_column($data, 'title');
                        
                        // Exclude the last two titles
                        $titlesToConcatenate = array_slice($titles, -2);

                        // Concatenate titles with the separator
                        $resultString = implode(' - ', $titlesToConcatenate);

                        // Output the result
                        return $resultString;
                    })->wrap(),
                Tables\Columns\TextColumn::make('parameter.hasil_kerja')
                    ->sortable()
                    ->label('Hasil Kerja')
                    ->badge(),
                Tables\Columns\TextColumn::make('parameter.angka_kredit')
                    ->sortable()
                    ->numeric()
                    ->label('Angka Kredit')
                    ->badge(),
                Tables\Columns\TextColumn::make('nilai')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('file')
                    ->simpleLightbox(fn (Penilaian $record) => env('APP_URL'). "storage/" . $record->file),
                Tables\Columns\IconColumn::make('approval')
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
            ])->recordUrl(
                fn () => null
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenilaians::route('/'),
        ];
    }
}
