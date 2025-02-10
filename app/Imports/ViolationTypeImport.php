<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\ViolationType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ViolationTypeImport implements ToModel, WithHeadingRow
{
    public $importedCount = 0; // Menyimpan jumlah data yang berhasil diimport
    public function model(array $row)
    {

        //$category_id = self::getCategoryId($row['category_id']);
        $this->importedCount++; // Tambahkan jumlah data yang berhasil diimport
        return new ViolationType([
            'name' => $row['name'],
            'points' => $row['point'],
            'category_id' => $row['category'],
        ]);
    }

}
