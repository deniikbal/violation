<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ViolationType;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ViolationTypeResource\Pages;
use App\Filament\Resources\ViolationTypeResource\RelationManagers;
use Filament\Tables\Actions\Action;

class ViolationTypeResource extends Resource
{
    protected static ?string $model = ViolationType::class;
    protected static ?string $label = 'Jenis Pelanggaran';
    protected static ?string $pluralLabel = 'Jenis Pelanggaran';

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function getNavigationBadge(): ?string
    {
        // Menghitung total siswa di database
        return ViolationType::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pelanggaran')
                    ->required(),
                Forms\Components\TextInput::make('points')
                    ->label('Poin')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Kategori')
                    ->options(Category::all()->pluck('name', 'id')) // Ambil daftar kategori
                    ->searchable() // Tambahkan fitur pencarian
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pelanggaran')
                    ->limit(50),
                Tables\Columns\TextColumn::make('points')
                    ->label('Poin'),
                Tables\Columns\TextColumn::make('category.name') // Ambil nama kategori dari relasi
                ->label('Kategori')
                ->searchable(),
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
            'index' => Pages\ListViolationTypes::route('/'),
            'create' => Pages\CreateViolationType::route('/create'),
            'edit' => Pages\EditViolationType::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data'; // Nama grup di sidebar
    }

    public static function getNavigationLabel(): string
    {
        return 'Jenis Pelanggaran'; // Label di sidebar
    }

    public static function getHeaderActions(): array
    {
        return [
            Action::make('import')
                ->label('Import Siswa')
                ->button()
                ->icon('heroicon-o-upload')
                ->url(fn () => route('filament.resources.students.import')),
        ];
    }
}
