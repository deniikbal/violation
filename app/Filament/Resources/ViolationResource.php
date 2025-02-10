<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use App\Models\Violation;
use Filament\Tables\Table;
use App\Models\ViolationType;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\DateFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\DateTimeColumn;
use App\Filament\Resources\ViolationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ViolationResource\RelationManagers;



class ViolationResource extends Resource
{
    protected static ?string $model = Violation::class;
    protected static ?string $label = 'Pelanggaran';
    protected static ?string $pluralLabel = 'Rekap Pelanggaran';


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        // Menghitung total siswa di database
        return Violation::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                ->label('Kategori')
                ->options(Category::all()->pluck('name', 'id')) // Daftar kategori
                ->searchable()
                ->required()
                ->reactive() // Aktifkan reaktivitas untuk memicu perubahan
                ->afterStateUpdated(fn ($state, callable $set) => $set('violation_type_id', null)), // Reset violation_type saat kategori berubah

                Forms\Components\Select::make('violation_type_id')
                ->label('Jenis Pelanggaran')
                ->options(function (callable $get) {
                    $categoryId = $get('category_id'); // Ambil nilai category_id yang dipilih
                    if ($categoryId) {
                        return ViolationType::where('category_id', $categoryId)->pluck('name', 'id'); // Filter violation_type berdasarkan category_id
                    }
                    return []; // Jika tidak ada kategori yang dipilih, kembalikan array kosong
                })
                ->searchable()
                ->required(),

                Forms\Components\Select::make('student_id')
                ->label('Siswa')
                ->relationship('student', 'name') // Relasi ke model Student
                ->preload()
                ->searchable()
                ->required(),

                Forms\Components\DatePicker::make('date')
                ->label('Tanggal')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                ->label('Siswa')
                ->searchable(),
                Tables\Columns\TextColumn::make('violationType.name')
                    ->label('Jenis Pelanggaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('violationType.points')
                    ->label('Poin'),
                Tables\Columns\TextColumn::make('student.classroom.name') // Mengakses nama kelas dari relasi
                    ->label('Kelas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                ->label('Tanggal')
                ->date(),
                Tables\Columns\TextColumn::make('user.name')
                ->label('Created By')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                SelectFilter::make('classroom')
                    ->label('Kelas')
                    ->relationship('student.classroom', 'name'), // Mengambil nama kelas dari relasi

                // Filter lainnya (opsional)
                SelectFilter::make('violation_type')
                    ->label('Jenis Pelanggaran')
                    ->relationship('violationType', 'name'),
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
            'index' => Pages\ListViolations::route('/'),
            'create' => Pages\CreateViolation::route('/create'),
            'edit' => Pages\EditViolation::route('/{record}/edit'),
        ];
    }
}
