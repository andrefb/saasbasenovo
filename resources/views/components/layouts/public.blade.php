<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="{{ $metaDescription ?? 'Tabela de vendas e disponibilidade' }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Tabela de Vendas' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏢</text></svg>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Styles & Scripts (Alpine via npm) -->
    @vite(['resources/css/public.css', 'resources/js/public.js'])
</head>
<body class="min-h-screen antialiased">
    {{ $slot }}
</body>
</html>
