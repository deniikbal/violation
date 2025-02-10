<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ViolationType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ViolationsRelationManager extends RelationManager
{
    protected static string $relationship = 'violations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label('Kategori')
                    ->options(Category::all()->pluck('name', 'id')) // Daftar kategori
                    ->searchable()
                    ->required()
                    ->reactive() // Aktifkan reaktivitas
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('violation_type_id', null); // Reset violation_type saat kategori berubah
                    }),

                Forms\Components\Select::make('violation_type_id')
                    ->label('Jenis Pelanggaran')
                    ->options(function (callable $get) {
                        $categoryId = $get('category_id'); // Ambil nilai category_id yang dipilih
                        if ($categoryId) {
                            return ViolationType::where('category_id', $categoryId)->pluck('name', 'id');
                        }
                        return []; // Jika tidak ada kategori yang dipilih, kembalikan array kosong
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('violationType.name')
                ->label('Jenis Pelanggaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('violationType.points')
                    ->label('Poin'),
                Tables\Columns\TextColumn::make('date')
                ->label('Tanggal')
                ->date(),
                Tables\Columns\TextColumn::make('user.name')
                ->label('Created By')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
