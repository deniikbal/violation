<?php

namespace App\Filament\Imports;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Validation\Rule;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nis')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('classroom') // Nama kolom di CSV adalah "classroom"
                ->label('Classroom')
                ->requiredMapping()
                ->relationship('classroom', 'name') // Relasi ke model Classroom berdasarkan nama
                ->rules([
                    'required',
                    Rule::exists('classrooms', 'name'), // Validasi berdasarkan nama kelas
                ]),
        ];
    }

    public function resolveRecord(): ?Student
    {
        return Student::firstOrNew([
            'nis' => $this->data['nis'], // Mencocokkan berdasarkan NIS
        ]);

        //return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    // public function beforeSave(): void
    // {
    //     // Cari classroom berdasarkan nama kelas
    //     $classroom = Classroom::where('name', $this->data['classroom'])->first();

    //     if (!$classroom) {
    //         throw new \Exception("Classroom '{$this->data['classroom']}' not found.");
    //     }

    //     // Set classroom_id pada model Student
    //     $this->record->classroom_id = $classroom->id;
    // }
}
