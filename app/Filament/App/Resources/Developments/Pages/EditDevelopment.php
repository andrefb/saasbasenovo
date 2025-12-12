<?php

namespace App\Filament\App\Resources\Developments\Pages;

use App\Filament\App\Resources\Developments\DevelopmentResource;
use App\Services\CloudinaryService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditDevelopment extends EditRecord
{
    protected static string $resource = DevelopmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['logo_upload'])) {
            $filename = is_array($data['logo_upload']) ? reset($data['logo_upload']) : $data['logo_upload'];
            $filePath = storage_path('app/private/' . $filename);

            if (file_exists($filePath)) {
                try {
                    $cloudinaryService = app(CloudinaryService::class);
                    $url = $cloudinaryService->upload($filePath, "developments/{$this->record->id}");

                    $data['logo_url'] = $url;
                    
                    Notification::make()
                        ->title('Logo atualizada!')
                        ->body('A nova imagem foi salva com sucesso.')
                        ->success()
                        ->send();
                        
                    @unlink($filePath);
                    
                } catch (\Exception $e) {
                    Log::error('Erro upload Cloudinary Development', ['msg' => $e->getMessage()]);

                    Notification::make()
                        ->title('Erro no upload')
                        ->body('Não foi possível enviar a imagem: ' . $e->getMessage())
                        ->danger()
                        ->send();
                }
            }
        }

        if (isset($data['logo_upload'])) {
            unset($data['logo_upload']);
        }

        return $data;
    }
}
