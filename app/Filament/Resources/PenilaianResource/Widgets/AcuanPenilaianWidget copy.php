<?php

namespace App\Filament\Resources\PenilaianResource\Widgets;

use App\Models\Golongan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AcuanPenilaianWidget extends BaseWidget
{
    protected static bool $isLazy = false;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Golongan::where('id', auth()->user()->golongan_id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Golongan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('file')
                    ->label('Berkas Acuan')
                    ->tooltip('Klik untuk memperbesar')
                    ->simpleLightbox(),
            ])
            ->paginated(false)
            ->searchable(false);
    }
}
