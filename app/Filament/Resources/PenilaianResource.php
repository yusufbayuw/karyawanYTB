<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Penilaian;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PenilaianResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PenilaianResource\RelationManagers;
use Filament\Forms\Set;
use Filament\Tables\Columns\Summarizers\Sum;

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
                    ->label('Pegawai')
                    ->disabled(),
                Forms\Components\Select::make('parameter_id')
                    ->relationship('parameter', 'title')
                    ->label('Parameter')
                    ->disabled(),
                Forms\Components\TextInput::make('nilai')
                    ->label('Kuantitas')
                    ->suffix(fn (Penilaian $penilaian) => $penilaian->parameter->hasil_kerja)
                    ->afterStateUpdated(function (Set $set, $state, Penilaian $record) {
                        if ($record->approval) {
                            $set('jumlah', (float)$state * (float)$record->parameter->angka_kredit);
                        }
                    })
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('file')
                    ->label('Unggah Berkas')
                    ->required(),
                Forms\Components\Toggle::make('approval')
                    ->label('Status Persetujuan Atasan')
                    ->disabled(fn (Penilaian $penilaian) => !((auth()->user()->jabatan_id === ($penilaian->user->jabatan->parent->id ?? false)) || auth()->user()->hasRole(['super_admin'])))
                    ->afterStateUpdated(function ($state, Penilaian $penilaian, Set $set) {
                        if ($state) {
                            $set('jumlah', ($penilaian->parameter->angka_kredit ?? 0) * ($penilaian->nilai ?? 0));
                        } 
                    }),
                Forms\Components\Hidden::make('jumlah'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pegawai')
                    ->sortable()
                    ->description(fn (Penilaian $penilaian) => $penilaian->user->unit->nama . ' - ' . $penilaian->user->jabatan->title . ' - ' . $penilaian->user->golongan->nama)
                    ->wrap(),
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
                    ->badge()
                    ->description(fn (Penilaian $penilaian) => 'Angka Kredit: '.$penilaian->parameter->angka_kredit),
                Tables\Columns\TextColumn::make('nilai')
                    ->label('Kuantitas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->formatStateUsing(fn ($state) => (explode('.', $state)[1] ?? 'file'))
                    ->url(fn ($state) => env('APP_URL') . "/storage/". $state, true),//(fn (Penilaian $record) => env('APP_URL'). "storage/" . $record->file),
                Tables\Columns\IconColumn::make('approval')
                    ->label('Persetujuan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Nilai')
                    ->summarize(Sum::make()),
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
                SelectFilter::make('pegawai')
                    ->relationship('user', 'name', fn (Builder $query) => $query)
            ])
            ->groups([
                Group::make('user.name')
                    ->titlePrefixedWithLabel(false)
                    ->label('Pegawai')
                    //->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('jurusan_id', 'asc')->orderBy('ranking', $direction)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->recordUrl(
                null
            )
            ->defaultGroup('user.name')
            ->groupsOnly(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenilaians::route('/'),
        ];
    }
}
