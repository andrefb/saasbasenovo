<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    /**
     * Faz upload de uma imagem para o Cloudinary.
     *
     * @param UploadedFile|string $file Arquivo ou caminho do arquivo
     * @param string $folder Pasta no Cloudinary
     * @param array $options Opções adicionais de transformação
     * @return string URL da imagem no Cloudinary
     */
    public function upload(UploadedFile|string $file, string $folder = 'logos', array $options = []): string
    {
        $path = $file instanceof UploadedFile ? $file->getRealPath() : $file;
        
        $defaultOptions = [
            'folder' => config('cloudinary.folder', 'saas') . '/' . $folder,
            'transformation' => [
                'width' => 500,
                'height' => 500,
                'crop' => 'limit',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ];

        $uploadOptions = array_merge($defaultOptions, $options);

        $result = Cloudinary::upload($path, $uploadOptions);

        return $result->getSecurePath();
    }

    /**
     * Faz upload de logo de empresa.
     */
    public function uploadLogo(UploadedFile|string $file, string $companyId): string
    {
        return $this->upload($file, "companies/{$companyId}/logo", [
            'public_id' => 'logo',
            'overwrite' => true,
            'transformation' => [
                'width' => 400,
                'height' => 400,
                'crop' => 'limit',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ]);
    }

    /**
     * Deleta uma imagem do Cloudinary.
     */
    public function delete(string $publicId): bool
    {
        $result = Cloudinary::destroy($publicId);
        return $result->getResult() === 'ok';
    }
}
