<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Empresa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Bem-vindo! 🚀</h1>
        <p class="text-gray-600 mb-6 text-center">Para começar, crie sua primeira empresa.</p>

        <form action="{{ route('company.store') }}" method="POST">
            @csrf <!-- Token de segurança obrigatório -->

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nome da Empresa</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">URL (Slug)</label>
                <input type="text" name="slug" placeholder="minha-empresa" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <button type="submit" class="w-full bg-amber-500 text-white font-bold py-2 px-4 rounded hover:bg-amber-600 transition">
                Criar e Acessar Painel
            </button>
        </form>
    </div>

</body>
</html>
