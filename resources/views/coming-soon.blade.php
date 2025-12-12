<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- SEO Meta Tags --}}
    <title>Em Breve | {{ config('app.name') }}</title>
    <meta name="description" content="Estamos preparando algo incrível. Em breve você poderá gerenciar empreendimentos, unidades e propostas de venda em um só lugar.">
    <meta name="robots" content="noindex, nofollow">
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css'])
    
    <style>
        * { font-family: 'Outfit', system-ui, sans-serif; }
        
        :root {
            --coral: #E07A5F;
            --coral-light: #F2CC8F;
            --navy: #1A1F2E;
            --navy-light: #2D3548;
            --cream: #F4F1DE;
            --sage: #81B29A;
        }
        
        .gradient-hero {
            background: linear-gradient(135deg, #1A1F2E 0%, #2D3548 40%, #3D4663 100%);
        }
        
        .gradient-coral {
            background: linear-gradient(135deg, #E07A5F 0%, #D9694C 100%);
        }
        
        /* Blob animado */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.3;
            animation: float 10s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }
        
        /* Pulse suave no logo */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(224, 122, 95, 0.3); }
            50% { box-shadow: 0 0 40px rgba(224, 122, 95, 0.5); }
        }
        
        .logo-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        /* Animação de entrada */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.8s ease forwards;
        }
        
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        
        /* Efeito de typing no texto */
        .typing-dots::after {
            content: '';
            animation: typing 1.5s steps(3, end) infinite;
        }
        
        @keyframes typing {
            0% { content: ''; }
            33% { content: '.'; }
            66% { content: '..'; }
            100% { content: '...'; }
        }
    </style>
</head>
<body class="bg-navy text-white antialiased overflow-x-hidden">
    
    <div class="gradient-hero min-h-screen flex items-center justify-center relative overflow-hidden">
        {{-- Decorative blobs --}}
        <div class="blob w-[500px] h-[500px] bg-coral/40 -top-64 -right-64"></div>
        <div class="blob w-[400px] h-[400px] bg-sage/30 -bottom-48 -left-48" style="animation-delay: -5s;"></div>
        <div class="blob w-[300px] h-[300px] bg-purple-500/20 top-1/2 left-1/4" style="animation-delay: -3s;"></div>
        
        <div class="max-w-2xl mx-auto px-6 text-center relative z-10">
            {{-- Logo --}}
            <div class="fade-up inline-flex items-center justify-center w-20 h-20 rounded-2xl gradient-coral mb-8 logo-glow">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            
            {{-- Brand name --}}
            <h1 class="fade-up delay-100 text-3xl sm:text-4xl font-bold mb-4">
                Gestão<span class="text-coral">&</span>Proposta
            </h1>
            
            {{-- Main message --}}
            <div class="fade-up delay-200 mb-6">
                <span class="inline-flex items-center gap-2 bg-white/5 backdrop-blur-sm border border-white/10 rounded-full px-5 py-2.5">
                    <span class="w-2 h-2 bg-coral rounded-full animate-pulse"></span>
                    <span class="text-white/70 font-medium">Estamos preparando algo incrível</span>
                </span>
            </div>
            
            <h2 class="fade-up delay-200 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                Em Breve<span class="typing-dots text-coral"></span>
            </h2>
            
            <p class="fade-up delay-300 text-lg sm:text-xl text-white/50 mb-10 max-w-lg mx-auto">
                O sistema completo para construtoras e incorporadoras gerenciarem empreendimentos, unidades e propostas de venda.
            </p>
            
            {{-- CTA removido temporariamente --}}
            
            {{-- Decorative features preview --}}
            <div class="fade-up delay-400 mt-16 grid grid-cols-3 gap-4 max-w-md mx-auto">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
                    <div class="text-2xl mb-1">🏢</div>
                    <div class="text-xs text-white/50">Empreendimentos</div>
                </div>
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
                    <div class="text-2xl mb-1">📋</div>
                    <div class="text-xs text-white/50">Propostas</div>
                </div>
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-4 text-center">
                    <div class="text-2xl mb-1">📊</div>
                    <div class="text-xs text-white/50">Relatórios</div>
                </div>
            </div>
        </div>
        
        {{-- Footer --}}
        <div class="absolute bottom-6 left-0 right-0 text-center">
            <p class="text-white/30 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
            </p>
        </div>
    </div>
    
</body>
</html>
