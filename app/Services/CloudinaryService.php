<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    protected Cloudinary $cloudinary;

    public function __construct()
    {
        // Usa sempre array de configuração (URL pode falhar em produção)
        Configuration::instance([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);

        $this->cloudinary = new Cloudinary();
    }

    /**
     * Faz upload de uma imagem para o Cloudinary.
     *
     * @param UploadedFile|string $file Arquivo ou caminho do arquivo
     * @param string $folder Pasta no Cloudinary
     * @param array $options Opções adicionais
     * @return string URL da imagem no Cloudinary
     */
    public function upload(UploadedFile|string $file, string $folder = 'logos', array $options = []): string
    {
        $path = $file instanceof UploadedFile ? $file->getRealPath() : $file;
        
        $defaultOptions = [
            'folder' => config('cloudinary.folder') . '/' . $folder,
            'transformation' => [
                'width' => 500,
                'height' => 500,
                'crop' => 'limit',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ],
        ];

        $uploadOptions = array_merge($defaultOptions, $options);

        $result = $this->cloudinary->uploadApi()->upload($path, $uploadOptions);

        return $result['secure_url'];
    }

    /**
     * Faz upload de logo de empresa.
     */
    public function uploadLogo(UploadedFile|string $file, string $companyId): string
    {
        return $this->upload($file, "companies/{$companyId}", [
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
        $result = $this->cloudinary->uploadApi()->destroy($publicId);
        return ($result['result'] ?? '') === 'ok';
    }
}
