<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    public $importedCount = 0; // Menyimpan jumlah data yang berhasil diimport
    public function model(array $row)
    {

        $classroom_id = self::getClassroomId($row['kelas']);
        $this->importedCount++; // Tambahkan jumlah data yang berhasil diimport
        return new Student([
            'name' => $row['name'],
            'nis' => $row['nis'],
            'classroom_id' => $classroom_id,
        ]);
    }
    public static function getClassroomId($classroom)
    {
        return Classroom::firstOrCreate(['name' => $classroom])->id;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'nis' => 'required|unique:students,nis',
            'kelas' => 'required',
        ];
    }
}
