<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;
    protected static ?string $label = 'Siswa';
    protected static ?string $pluralLabel = 'Daftar Siswa';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function getNavigationBadge(): ?string
    {
        return Student::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
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
                ->relationship('classroom', 'name')
                ->preload()
                ->searchable()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('nis'),
            TextColumn::make('classroom.name')
                ->label('Kelas')
                ->sortable(),
            TextColumn::make('total_points')
                ->label('Total Poin Pelanggaran')
                ->getStateUsing(fn ($record) => $record->total_points)
                ->sortable()
                ->badge()
                ->color(fn ($state): string => match (true) {
                    $state <= 30 => 'success',
                    $state > 30 && $state <= 60 => 'warning',
                    $state > 60 && $state < 90 => 'danger',
                    default => 'gray',
                }),
        ])
        ->filters([
            SelectFilter::make('classroom')
                ->relationship('classroom', 'name')
                ->label('Filter Kelas')
                ->searchable()
                ->preload(),
            //awal select
            Filter::make('total_points_range')
            ->label('Filter Total Poin Pelanggaran')
            ->form([
                Select::make('total_points_range')
                    ->options([
                        '<30' => 'Kurang dari 30 Poin',
                        '30-60' => '30 - 60 Poin',
                        '60-90' => '60 - 90 Poin',
                        '>90' => 'Lebih dari 90 Poin',])
                    ->label('Pilih Rentang Poin'),
                ])//Pentutup form
                ->query(function ($query, array $data) {
                    if (!empty($data['total_points_range'])) {
                        $range = $data['total_points_range'];
                        $query->whereHas('violations', function ($q) use ($range) {
                            $q->join('violation_types', 'violations.violation_type_id', '=', 'violation_types.id')
                              ->selectRaw('student_id, SUM(violation_types.points) as total')
                              ->groupBy('student_id');

                            // Menambahkan kondisi berdasarkan rentang poin
                            switch ($range) {
                                case '<30':
                                    $q->havingRaw('SUM(violation_types.points) < 30');
                                    break;
                                case '30-60':
                                    $q->havingRaw('SUM(violation_types.points) >= 30 AND SUM(violation_types.points) <= 60');
                                    break;
                                case '60-90':
                                    $q->havingRaw('SUM(violation_types.points) > 60 AND SUM(violation_types.points) <= 90');
                                    break;
                                case '>90':
                                    $q->havingRaw('SUM(violation_types.points) > 90');
                                    break;
                            }
                        });
                    }
                }),
                //penutup filter
        ])//ini penutup array
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['violations.violationType']);
    }
}
