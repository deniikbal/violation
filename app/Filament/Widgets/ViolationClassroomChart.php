<?php

namespace App\Filament\Widgets;

use App\Models\Violation;
use Filament\Widgets\ChartWidget;

class ViolationClassroomChart extends ChartWidget
{
    protected static ?string $heading = '10 Kelas Terbanyak Melakukan Pelanggaran';

    protected function getData(): array
    {
        // Query untuk mengambil 10 kelas dengan jumlah pelanggaran terbanyak
        $data = Violation::query()
            ->join('students', 'violations.student_id', '=', 'students.id') // Hubungkan violations dengan students
            ->join('classrooms', 'students.classroom_id', '=', 'classrooms.id') // Hubungkan students dengan classrooms
            ->selectRaw('classrooms.name as classroom_name, COUNT(*) as total_violations')
            ->groupBy('classrooms.id', 'classrooms.name')
            ->orderByDesc('total_violations')
            ->limit(10)
            ->get();

        // Format data untuk chart
        $labels = $data->pluck('classroom_name')->toArray();
        $values = $data->pluck('total_violations')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Pelanggaran',
                    'data' => $values,
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF', '#FFD700', '#8B0000', '#008000'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
