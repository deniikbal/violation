<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Violation;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestViolations extends BaseWidget
{
    protected static ?int $sort = 4;
    protected function getTableHeading(): string
    {
        return 'Pelanggaran Terbaru';
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Violation::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->sortable(),
                Tables\Columns\TextColumn::make('violationType.name')
                    ->label('Pelanggaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->sortable(),
            ]);
    }
}
