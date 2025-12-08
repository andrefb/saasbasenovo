<?php

return [
    /*
    |--------------------------------------------------------------------------
    | App Panel Domain (Opcional)
    |--------------------------------------------------------------------------
    |
    | Domínio para o painel das empresas (tenants). Em ambiente local, deixe
    | vazio para usar path-based (localhost:8000/app/empresa). Em produção,
    | configure o subdomínio desejado (ex: app.meudominio.com.br).
    |
    | Local: FILAMENT_APP_DOMAIN=
    | Produção: FILAMENT_APP_DOMAIN=app.meudominio.com.br
    |
    */
    'app_domain' => env('FILAMENT_APP_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Domain (Opcional)
    |--------------------------------------------------------------------------
    |
    | Domínio para o painel do super admin. Em ambiente local, deixe vazio
    | para usar path-based (localhost:8000/meuadmin). Em produção, pode
    | configurar um subdomínio (ex: meuadmin.meudominio.com.br).
    |
    */
    'admin_domain' => env('FILAMENT_ADMIN_DOMAIN'),
];
