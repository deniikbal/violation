<?php

namespace App\Filament\Widgets;

use App\Models\Violation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ViolationChart extends ChartWidget
{
    protected static ?string $heading = 'Pelanggaran Per Bulan';

    protected function getData(): array
    {


    $data = Violation::select(
        DB::raw('TO_CHAR(date, \'YYYY-MM\') as month'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

    // Ekstrak label (bulan) dan nilai (total pelanggaran)
    $labels = $data->pluck('month')->toArray();
    $values = $data->pluck('total')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Pelanggaran',
                    'data' => $values,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#36A2EB',
                    'fill' => false,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
