<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use App\Models\User;
use Filament\Tables;
use App\Models\Periode;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Penilaian;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\KategoriPenilaian;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Sum;
use App\Filament\Resources\PenilaianResource\Pages;


class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;

    protected static int $maxDepth = 7;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $modelLabel = 'Penilaian';

    protected static ?string $navigationGroup = 'Angka Kredit';

    protected static ?int $navigationSort = 12;

    protected static ?string $navigationLabel = 'Penilaian';

    protected static ?string $slug = 'angka-kredit-penilaian';

    public static function getEloquentQuery(): Builder
    {
        $periodeAktifId = Periode::where('is_active', true)->first()->id;
        $userAuth = auth()->user();
        if ($userAuth->hasRole(['super_admin'])) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('user_id', $userAuth->id)->orWhere('user_id', User::find($userAuth->id)->children->id ?? $userAuth->id)->where('periode_id', $periodeAktifId);
        }
    }

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
                    ->wrap()
                    ->description(fn (Penilaian $penilaian) => 'Angka Kredit: ' . $penilaian->parameter->angka_kredit),
                Tables\Columns\TextColumn::make('nilai')
                    ->label('Kuantitas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->formatStateUsing(fn ($state) => (explode('.', $state)[1] ?? 'file'))
                    ->url(fn ($state) => env('APP_URL') . "/storage/" . $state, true), //(fn (Penilaian $record) => env('APP_URL'). "storage/" . $record->file),
                Tables\Columns\IconColumn::make('approval')
                    ->label('Persetujuan')
                    ->boolean()
                    ->action(function ($record, $column, Penilaian $penilaian) {
                        $name = $column->getName();
                        if ($penilaian->file && $penilaian->nilai && ((auth()->user()->id === $penilaian->parameter->parent->id ?? false) || auth()->user()->hasRole(['super_admin']))) {
                            $record->update([
                                $name => !$record->$name
                            ]);
                        }
                    }),
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
                /* SelectFilter::make('pegawai')
                    ->relationship('user', 'name', fn (Builder $query) => $query->where('id', auth()->user()->id)->orWhere('id', User::find(auth()->user()->id)->children->id ?? auth()->user()->id))
                    ->default(fn () => auth()->user()->id), */
                Filter::make('ppak')
                    ->form([
                        Forms\Components\Select::make('unit_filter')
                            ->label('Pilih Unit')
                            ->options(fn () => Unit::all()->pluck('nama', 'id'))
                            ->default(fn () => auth()->user()->unit_id)
                            ->disabled(!auth()->user()->hasRole(['super_admin'])),
                        Forms\Components\Select::make('pegawai_filter')
                            ->label('Pilih Karyawan')
                            ->options(fn (Get $get) => User::where('id', auth()->user()->id)->orWhere('id', User::find(auth()->user()->id)->children->id ?? auth()->user()->id)->where('unit_id', $get('unit_filter') ?? 0)->pluck('name', 'id'))
                            ->disabled(fn (Get $get) => $get('unit_filter') == null)
                            ->default(auth()->user()->id),
                        Forms\Components\Select::make('kategori_filter')
                            ->label('Pilih Kategori')
                            ->options(fn (Get $get) => KategoriPenilaian::all()->pluck('nama', 'id'))
                            ->default(fn () => KategoriPenilaian::orderBy('id', 'asc')->first()->id),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->where('user_id',$data['pegawai_filter'])->where('kategori_id', $data['kategori_filter']);
                    })->indicateUsing(function (array $data): ?string {
                        if (!$data['pegawai_filter'] || !$data['unit_filter'] || !$data['kategori_filter']) {
                            return null;
                        }

                        return Unit::find($data['unit_filter'])->nama . ': ' . User::find($data['pegawai_filter'])->name . ' - ' . (KategoriPenilaian::find($data['kategori_filter'])->nama ?? null);
                    }),
            ])
            ->groups([
                Group::make('user.name')
                    ->titlePrefixedWithLabel(false)
                    ->label('Pegawai'),
                Group::make('leluhur')
                    ->titlePrefixedWithLabel(false)
                    ->label('Unsur'),
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
            ->defaultGroup('leluhur')
            ->defaultPaginationPageOption('all')
            ->groupsOnly(fn () => auth()->user()->gruop_penilaian);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePenilaians::route('/'),
        ];
    }
}
