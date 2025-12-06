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
        // Configura usando CLOUDINARY_URL ou variáveis separadas
        $cloudinaryUrl = env('CLOUDINARY_URL');
        
        if ($cloudinaryUrl) {
            Configuration::instance($cloudinaryUrl);
        } else {
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => [
                    'secure' => true,
                ],
            ]);
        }

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
            'folder' => env('CLOUDINARY_FOLDER', 'saas') . '/' . $folder,
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
