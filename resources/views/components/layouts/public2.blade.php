<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Tabela de vendas e disponibilidade' }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Tabela de Vendas' }}</title>
    
    <!-- Fonts - Google Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Styles & Scripts -->
    @vite(['resources/css/public2.css', 'resources/js/public.js'])
</head>
<body class="min-h-screen">
    {{ $slot }}
</body>
</html>
