<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Imports\ClassroomImporter;
use App\Filament\Resources\ClassroomResource;
use App\Imports\ClassroomImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Filament\Notifications\Notification;

class ListClassrooms extends ListRecords
{
    protected static string $resource = ClassroomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // \EightyNine\ExcelImport\ExcelImportAction::make()
            //     ->label('Import Kelas')
            //     ->slideOver()
            //     ->icon('heroicon-o-document-arrow-down')
            //     ->color('danger')
            //     ->use(ClassroomImport::class),
            ImportAction::make()
                ->importer(ClassroomImporter::class)

        ];
    }
}
