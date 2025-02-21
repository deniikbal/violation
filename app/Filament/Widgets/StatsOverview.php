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
                ->description('User')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Jmlah Siswa', Student::count())
                ->description('Siswa')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Jumlah Kelas', Classroom::count())
                ->description('Kelas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Jumlah Pelanggaran', Violation::count())
                ->description('Pelanggaran')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
