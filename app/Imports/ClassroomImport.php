<?php

namespace App\Imports;

use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClassroomImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $importedCount = 0; // Menyimpan jumlah data yang berhasil diimport
    public function model(array $row)
    {


        //$category_id = self::getCategoryId($row['category_id']);
        $this->importedCount++; // Tambahkan jumlah data yang berhasil diimport
        return new Classroom([
            'name' => $row['kelas'],
            'teacher' => $row['walikelas'],
        ]);
    }
}
