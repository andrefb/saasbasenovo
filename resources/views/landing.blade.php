<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestão e Proposta - Sistema completo para gestão de empreendimentos imobiliários de construtoras">
    <title>Gestão e Proposta - Gerencie seus Empreendimentos</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    {{-- Styles --}}
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px rgba(99, 102, 241, 0.25);
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }
        .animate-delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body class="bg-slate-950 text-white antialiased">
    {{-- Header --}}
    <header class="fixed top-0 left-0 right-0 z-50 bg-slate-950/80 backdrop-blur-lg border-b border-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                {{-- Logo --}}
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-lg sm:text-xl font-bold text-white">Gestão<span class="text-indigo-400">&</span>Proposta</span>
                </div>
                
                {{-- Login Button --}}
                <a href="/login" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 text-sm font-medium text-white bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors duration-200 border border-slate-700 hover:border-slate-600">
                    <span>Entrar</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="hero-gradient min-h-screen flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="fade-in text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                    Gerencie seus empreendimentos com 
                    <span class="gradient-text">simplicidade e eficiência</span>
                </h1>
                
                <p class="fade-in animate-delay-100 text-base sm:text-lg md:text-xl text-slate-400 mb-8 sm:mb-10 max-w-2xl mx-auto leading-relaxed">
                    Sistema completo para construtoras. Controle empreendimentos, unidades, propostas de venda e tabela de preços em um só lugar.
                </p>
                
                <div class="fade-in animate-delay-200 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/login" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 rounded-xl transition-all duration-200 shadow-lg shadow-indigo-500/25">
                        Começar Agora
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits Section --}}
    <section class="py-16 sm:py-24 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4">
                    Por que escolher o Gestão e Proposta?
                </h2>
                <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto">
                    Desenvolvido para simplificar a rotina da sua construtora
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                {{-- Benefit 1 --}}
                <div class="card-hover bg-slate-800/50 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Rapidez</h3>
                    <p class="text-slate-400 text-sm sm:text-base">Atualize informações em segundos. Interface otimizada para produtividade.</p>
                </div>
                
                {{-- Benefit 2 --}}
                <div class="card-hover bg-slate-800/50 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Facilidade</h3>
                    <p class="text-slate-400 text-sm sm:text-base">Intuitivo e fácil de usar. Sua equipe aprende em minutos.</p>
                </div>
                
                {{-- Benefit 3 --}}
                <div class="card-hover bg-slate-800/50 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Acessível</h3>
                    <p class="text-slate-400 text-sm sm:text-base">Acesse de qualquer lugar, a qualquer momento. 100% na nuvem.</p>
                </div>
                
                {{-- Benefit 4 --}}
                <div class="card-hover bg-slate-800/50 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Mobile</h3>
                    <p class="text-slate-400 text-sm sm:text-base">Totalmente responsivo. Funciona perfeitamente no celular e tablet.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-16 sm:py-24 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 sm:mb-16">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4">
                    Tudo que você precisa
                </h2>
                <p class="text-slate-400 text-base sm:text-lg max-w-2xl mx-auto">
                    Ferramentas poderosas para gerenciar cada aspecto dos seus empreendimentos
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                {{-- Feature 1 --}}
                <div class="card-hover bg-gradient-to-br from-slate-800/80 to-slate-900/80 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Gestão de Empreendimentos</h3>
                            <p class="text-slate-400 text-sm sm:text-base">Cadastre e gerencie todos os seus empreendimentos em um só lugar. Acompanhe o progresso e status de cada projeto.</p>
                        </div>
                    </div>
                </div>
                
                {{-- Feature 2 --}}
                <div class="card-hover bg-gradient-to-br from-slate-800/80 to-slate-900/80 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Controle de Unidades</h3>
                            <p class="text-slate-400 text-sm sm:text-base">Gerencie apartamentos, casas, salas e lotes. Visualize disponibilidade em tempo real com mapas interativos.</p>
                        </div>
                    </div>
                </div>
                
                {{-- Feature 3 --}}
                <div class="card-hover bg-gradient-to-br from-slate-800/80 to-slate-900/80 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Propostas de Venda</h3>
                            <p class="text-slate-400 text-sm sm:text-base">Crie e acompanhe propostas comerciais. Histórico completo de negociações e aprovações.</p>
                        </div>
                    </div>
                </div>
                
                {{-- Feature 4 --}}
                <div class="card-hover bg-gradient-to-br from-slate-800/80 to-slate-900/80 rounded-2xl p-6 sm:p-8 border border-slate-700/50">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-semibold text-white mb-2">Tabela de Preços</h3>
                            <p class="text-slate-400 text-sm sm:text-base">Gerencie tabelas de preços e disponibilidade. Atualize valores e compartilhe com corretores facilmente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 sm:py-24 bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4 sm:mb-6">
                Pronto para transformar sua gestão?
            </h2>
            <p class="text-slate-300 text-base sm:text-lg mb-8 max-w-2xl mx-auto">
                Comece agora e veja como o Gestão e Proposta pode simplificar o dia a dia da sua construtora.
            </p>
            <a href="/login" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-base font-semibold text-indigo-900 bg-white hover:bg-slate-100 rounded-xl transition-all duration-200 shadow-lg">
                Acessar o Sistema
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-8 bg-slate-950 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-slate-400">Gestão e Proposta</span>
                </div>
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
