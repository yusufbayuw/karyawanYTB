<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TingkatJabatan;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use App\Filament\Exports\UserExporter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Filament\Actions\Exports\Enums\ExportFormat;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Pegawai';

    protected static ?string $navigationGroup = 'Pegawai';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Pegawai';

    protected static ?string $slug = 'pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('unit_id')
                    ->relationship('unit', 'nama'),
                Forms\Components\Select::make('golongan_id')
                    ->relationship('golongan', 'nama')
                    ->live(),
                Forms\Components\Select::make('tingkat_id')
                    ->options(fn (Get $get) => TingkatJabatan::where('golongan_id', $get('golongan_id'))->pluck('title', 'id'))
                    ->disabled(fn (Get $get) => $get('golongan_id') === null),
                Forms\Components\Select::make('jabatan_id')
                    ->relationship('jabatan', 'title'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->label('Nomor Induk Pegawai')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(static fn (null|string $state): null|string => filled($state) ? Hash::make($state) : null,)
                    ->dehydrated(static fn (null|string $state): bool => filled($state))
                    ->maxLength(255)
                    ->label('Kata Sandi'),
                Forms\Components\CheckboxList::make('roles')
                    ->relationship('roles', 'name')
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit.nama')
                    ->label('Unit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jabatan.title')
                    ->label('Jabatan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('golongan.nama')
                    ->sortable()
                    ->formatStateUsing(fn (User $user) => $user->golongan->nama . ' - ' . $user->tingkat->title),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->label('NIP')
                    ->copyable()
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
                    ExportBulkAction::make('Export Pilihan')
                        ->exporter(UserExporter::class)
                        ->formats([
                            ExportFormat::Xlsx,
                        ])
                        ->fileName(fn (): string => "pegawai-". time() .".xlsx"),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
