<?php

namespace App\Filament\Resources\ViolationResource\Pages;

use App\Filament\Resources\ViolationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class AllViolations extends ListRecords
{
    protected static string $resource = ViolationResource::class;
}
