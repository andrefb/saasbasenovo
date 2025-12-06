<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Credenciais do Cloudinary para upload de imagens.
    | Obtenha em: https://console.cloudinary.com/settings/c-[seu-cloud]/api-keys
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),

    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Upload Options
    |--------------------------------------------------------------------------
    */

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    // Pasta padrão para uploads
    'folder' => env('CLOUDINARY_FOLDER', 'saas'),

    // Transformações padrão para logos
    'logo_transformation' => [
        'width' => 500,
        'height' => 500,
        'crop' => 'limit',
        'quality' => 'auto',
        'fetch_format' => 'auto',
    ],
];
