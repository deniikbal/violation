<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;


class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $label = 'Siswa';
    protected static ?string $pluralLabel = 'Daftar Siswa';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function getNavigationBadge(): ?string
    {
        // Menghitung total siswa di database
        return Student::count();
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
            ->label('Nama Lengkap')
            ->unique(Student::class, 'name', ignoreRecord: true)
            ->required(),
            TextInput::make('nis')
            ->label('Nomor Induk Siswa')
            ->unique(Student::class, 'nis', ignoreRecord: true)
            ->required(),
            Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name') // Relasi ke model Classroom
                    ->preload() // Memuat semua data kelas secara otomatis
                    ->searchable() // Menambahkan fitur pencarian di dropdown
                    ->required(),
            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
            ->searchable(),
            TextColumn::make('nis'),
            Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Kelas')
                    ->sortable(),
            Tables\Columns\TextColumn::make('total_points')
                    ->label('Total Poin Pelanggaran')
                    ->getStateUsing(fn ($record) => $record->total_points) // Menggunakan accessor
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('download')
                    ->label('download')
                    ->url(fn (Student $record): string => route('student.download', $record))
                    ->openUrlInNewTab(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ViolationsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Data berhasil disimpan')
            ->body('Data siswa telah berhasil ditambahkan.')
            ->actions([
                Action::make('view_students')
                    ->label('Lihat Daftar Siswa')
                    ->url(static::getUrl('index')), // Redirect ke halaman tabel
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['violations.violationType']);
    }
}
