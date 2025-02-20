<?php

namespace App\Filament\Widgets;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use App\Models\Violation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah User', User::count())
                ->description('Semua User')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Jmlah Siswa', Student::count())
                ->description('Semua Siswa')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Jumlah Kelas', Classroom::count())
                ->description('Semua Pelanggaran')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Jumlah Pelanggaran', Violation::count())
                ->description('Semua Pelanggaran')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
