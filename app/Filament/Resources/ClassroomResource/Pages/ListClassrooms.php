<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use App\Imports\ClassroomImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
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
            Action::make('import')
            ->label('Import')
            ->color('danger')
            ->icon('heroicon-o-document-arrow-down')
            ->form([
                FileUpload::make('attachment')
            ])
            ->action(function(array $data) {
                try {
                    // Path file yang diupload
                    $file = public_path('storage/' . $data['attachment']);

                   // Inisialisasi class import
                    $import = new ClassroomImport();

                    // Proses import menggunakan Laravel Excel
                    Excel::import($import, $file);

                    Notification::make()
                    ->title('Import berhasil!')
                    ->body("{$import->importedCount} Kelas Berhasil diimport")
                    ->success()
                    ->send();
                } catch (ValidationException $e) {
                    // Tangkap exception validasi dari Laravel Excel
                    $failures = $e->failures();

                    // Format pesan error untuk ditampilkan
                    $errorMessages = [];
                    foreach ($failures as $failure) {
                        $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
                    }

                    // Tampilkan notifikasi error
                    Notification::make()
                        ->title('Gagal melakukan import!')
                        ->body(implode("\n", $errorMessages))
                        ->danger()
                        ->send();
                } catch (\Exception $e) {
                    // Tangkap exception lainnya (misalnya file tidak valid)
                    Notification::make()
                        ->title('Terjadi kesalahan!')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }

            })
        ];
    }
}
