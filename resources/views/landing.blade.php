<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- SEO Meta Tags --}}
    <title>Gestão e Proposta | Sistema para Construtoras e Incorporadoras</title>
    <meta name="description" content="Gerencie empreendimentos, unidades e propostas de venda em um só lugar. Crie propostas em 2 minutos e acompanhe negociações em tempo real.">
    <meta name="keywords" content="gestão imobiliária, construtora, incorporadora, propostas de venda, empreendimentos">
    <link rel="canonical" href="{{ config('app.url') }}">
    
    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="Gestão e Proposta | Sistema para Construtoras">
    <meta property="og:description" content="Gerencie empreendimentos e crie propostas de venda em minutos.">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:locale" content="pt_BR">
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css'])
    
    <style>
        * { font-family: 'Outfit', system-ui, sans-serif; }
        
        /* Paleta de cores customizada - Coral/Terracota com Navy */
        :root {
            --coral: #E07A5F;
            --coral-light: #F2CC8F;
            --navy: #1A1F2E;
            --navy-light: #2D3548;
            --cream: #F4F1DE;
            --sage: #81B29A;
        }
        
        .bg-coral { background-color: var(--coral); }
        .bg-navy { background-color: var(--navy); }
        .bg-cream { background-color: var(--cream); }
        .text-coral { color: var(--coral); }
        .text-navy { color: var(--navy); }
        .border-coral { border-color: var(--coral); }
        
        /* Gradientes únicos */
        .gradient-hero {
            background: linear-gradient(135deg, #1A1F2E 0%, #2D3548 40%, #3D4663 100%);
        }
        
        .gradient-coral {
            background: linear-gradient(135deg, #E07A5F 0%, #D9694C 100%);
        }
        
        .gradient-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.02) 100%);
        }
        
        /* Blob animado */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        
        /* Animações suaves */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease forwards;
        }
        
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        
        /* Hover cards */
        .card-lift {
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
        }
        .card-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(224, 122, 95, 0.25);
        }
        
        /* Numeric counter style */
        .number-badge {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #E07A5F 0%, #D9694C 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
        }
        
        /* Pricing popular badge */
        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #81B29A 0%, #6A9B84 100%);
            color: white;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Mobile menu */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        .mobile-menu.open {
            transform: translateX(0);
        }
        
        /* Smooth scroll behavior */
        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body class="bg-navy text-white antialiased overflow-x-hidden">

    {{-- Toast de Logout --}}
    @if(request()->has('logout'))
    <div id="logout-toast" class="fixed top-24 left-1/2 -translate-x-1/2 z-[100] bg-sage text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="font-medium">Até logo! Sessão encerrada.</span>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('logout-toast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => toast.remove(), 500);
            }
            window.history.replaceState({}, document.title, window.location.pathname);
        }, 4000);
    </script>
    @endif

    {{-- ========== HEADER ========== --}}
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center justify-between h-20" role="navigation" aria-label="Menu principal">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl gradient-coral flex items-center justify-center transform group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold">Gestão<span class="text-coral">&</span>Proposta</span>
                </a>
                
                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#funcionalidades" class="text-white/70 hover:text-white transition-colors font-medium">Funcionalidades</a>
                    <a href="#como-funciona" class="text-white/70 hover:text-white transition-colors font-medium">Como funciona</a>
                    <a href="#precos" class="text-white/70 hover:text-white transition-colors font-medium">Preços</a>
                    <a href="#faq" class="text-white/70 hover:text-white transition-colors font-medium">FAQ</a>
                </div>
                
                {{-- CTA Buttons --}}
                <div class="hidden md:flex items-center gap-4">
                    <a href="/app/login" class="text-white/80 hover:text-white transition-colors font-medium">Entrar</a>
                    <a href="/app/register" class="gradient-coral text-white px-5 py-2.5 rounded-xl font-semibold hover:opacity-90 transition-opacity">
                        Começar grátis
                    </a>
                </div>
                
                {{-- Mobile Menu Button --}}
                <button type="button" class="md:hidden p-2 text-white" onclick="toggleMobileMenu()" aria-label="Abrir menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </nav>
        </div>
        
        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="mobile-menu fixed inset-y-0 right-0 w-80 max-w-full bg-navy-light shadow-2xl md:hidden z-50">
            <div class="p-6">
                <button type="button" onclick="toggleMobileMenu()" class="absolute top-6 right-6 text-white/70" aria-label="Fechar menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <nav class="flex flex-col gap-6 mt-12">
                    <a href="#funcionalidades" onclick="toggleMobileMenu()" class="text-lg font-medium text-white/80 hover:text-white">Funcionalidades</a>
                    <a href="#como-funciona" onclick="toggleMobileMenu()" class="text-lg font-medium text-white/80 hover:text-white">Como funciona</a>
                    <a href="#precos" onclick="toggleMobileMenu()" class="text-lg font-medium text-white/80 hover:text-white">Preços</a>
                    <a href="#faq" onclick="toggleMobileMenu()" class="text-lg font-medium text-white/80 hover:text-white">FAQ</a>
                    <hr class="border-white/10">
                    <a href="/app/login" class="text-lg font-medium text-white/80 hover:text-white">Entrar</a>
                    <a href="/app/register" class="gradient-coral text-white text-center py-3 rounded-xl font-semibold">Começar grátis</a>
                </nav>
            </div>
        </div>
    </header>

    <main role="main">
        {{-- ========== HERO SECTION ========== --}}
        <section class="gradient-hero min-h-screen flex items-center pt-20 relative overflow-hidden">
            {{-- Decorative blobs --}}
            <div class="blob w-96 h-96 bg-coral/30 -top-48 -right-48"></div>
            <div class="blob w-64 h-64 bg-sage/20 bottom-20 -left-32" style="animation-delay: -4s;"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    {{-- Left Content --}}
                    <div class="text-center lg:text-left">
                        {{-- Badge --}}
                        <div class="fade-up inline-flex items-center gap-2 bg-white/5 backdrop-blur-sm border border-white/10 rounded-full px-4 py-2 mb-6">
                            <span class="w-2 h-2 bg-sage rounded-full animate-pulse"></span>
                            <span class="text-sm text-white/70">Teste grátis por 15 dias</span>
                        </div>
                        
                        <h1 class="fade-up delay-100 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                            Propostas de venda em
                            <span class="text-coral">2 minutos</span>,
                            não em 2 horas
                        </h1>
                        
                        <p class="fade-up delay-200 text-lg sm:text-xl text-white/60 mb-8 max-w-xl mx-auto lg:mx-0">
                            O sistema que construtoras usam para gerenciar empreendimentos, unidades e negociações — tudo em um só lugar.
                        </p>
                        
                        {{-- CTA Buttons --}}
                        <div class="fade-up delay-300 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="/app/register" class="inline-flex items-center justify-center gap-2 gradient-coral text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:opacity-90 transition-opacity shadow-lg shadow-coral/25">
                                Criar conta grátis
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                            <a href="#como-funciona" class="inline-flex items-center justify-center gap-2 bg-white/5 backdrop-blur-sm border border-white/20 text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white/10 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Ver como funciona
                            </a>
                        </div>
                        
                        {{-- Stats --}}
                        <div class="fade-up delay-400 flex flex-wrap justify-center lg:justify-start gap-8 mt-12 pt-8 border-t border-white/10">
                            <div>
                                <span class="block text-3xl font-bold text-coral">2min</span>
                                <span class="text-sm text-white/50">para criar proposta</span>
                            </div>
                            <div>
                                <span class="block text-3xl font-bold text-coral">100%</span>
                                <span class="text-sm text-white/50">na nuvem</span>
                            </div>
                            <div>
                                <span class="block text-3xl font-bold text-coral">15 dias</span>
                                <span class="text-sm text-white/50">grátis para testar</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Right Content - Dashboard Preview --}}
                    <div class="fade-up delay-300 relative">
                        <div class="relative bg-gradient-card rounded-3xl border border-white/10 p-4 shadow-2xl">
                            {{-- Mock Dashboard --}}
                            <div class="bg-navy rounded-2xl overflow-hidden">
                                {{-- Top bar --}}
                                <div class="bg-white/5 px-4 py-3 flex items-center gap-3 border-b border-white/10">
                                    <div class="flex gap-1.5">
                                        <div class="w-3 h-3 rounded-full bg-coral/60"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-400/60"></div>
                                        <div class="w-3 h-3 rounded-full bg-sage/60"></div>
                                    </div>
                                    <div class="flex-1 text-center text-sm text-white/40">dashboard.gestaoproposta.com.br</div>
                                </div>
                                {{-- Dashboard content --}}
                                <div class="p-6 space-y-4">
                                    {{-- Cards row --}}
                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="bg-white/5 rounded-xl p-4">
                                            <div class="text-2xl font-bold text-coral">127</div>
                                            <div class="text-xs text-white/50">Unidades</div>
                                        </div>
                                        <div class="bg-white/5 rounded-xl p-4">
                                            <div class="text-2xl font-bold text-sage">84</div>
                                            <div class="text-xs text-white/50">Vendidas</div>
                                        </div>
                                        <div class="bg-white/5 rounded-xl p-4">
                                            <div class="text-2xl font-bold text-white">23</div>
                                            <div class="text-xs text-white/50">Propostas</div>
                                        </div>
                                    </div>
                                    {{-- Table preview --}}
                                    <div class="bg-white/5 rounded-xl p-4 space-y-3">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-white/70">Residencial Aurora - Ap 301</span>
                                            <span class="px-2 py-1 bg-sage/20 text-sage rounded-lg text-xs">Vendido</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-white/70">Residencial Aurora - Ap 402</span>
                                            <span class="px-2 py-1 bg-coral/20 text-coral rounded-lg text-xs">Em negociação</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-white/70">Residencial Aurora - Ap 205</span>
                                            <span class="px-2 py-1 bg-white/10 text-white/60 rounded-lg text-xs">Disponível</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Floating badge --}}
                        <div class="absolute -bottom-4 -left-4 bg-white text-navy px-4 py-3 rounded-2xl shadow-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-sage/20 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">Proposta enviada!</div>
                                    <div class="text-xs text-navy/60">Agora mesmo</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ========== FUNCIONALIDADES ========== --}}
        <section id="funcionalidades" class="py-20 lg:py-32 bg-navy relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-coral font-semibold uppercase tracking-wider text-sm">Funcionalidades</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mt-4 mb-6">
                        Tudo que sua construtora precisa
                    </h2>
                    <p class="text-lg text-white/60">
                        Ferramentas práticas pensadas para o dia a dia de quem vende imóveis
                    </p>
                </div>
                
                {{-- Features Grid --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    {{-- Feature 1 --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <div class="w-14 h-14 rounded-2xl bg-coral/20 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Gestão de Empreendimentos</h3>
                        <p class="text-white/60">Cadastre todos os seus lançamentos. Acompanhe o andamento de cada projeto em um painel visual.</p>
                    </div>
                    
                    {{-- Feature 2 --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <div class="w-14 h-14 rounded-2xl bg-sage/20 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Controle de Unidades</h3>
                        <p class="text-white/60">Visualize a disponibilidade em tempo real. Apartamentos, casas, salas ou lotes organizados.</p>
                    </div>
                    
                    {{-- Feature 3 --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <div class="w-14 h-14 rounded-2xl bg-yellow-400/20 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Propostas de Venda</h3>
                        <p class="text-white/60">Crie propostas comerciais em minutos. Histórico completo de negociações e aprovações.</p>
                    </div>
                    
                    {{-- Feature 4 --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <div class="w-14 h-14 rounded-2xl bg-purple-400/20 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Tabela de Preços</h3>
                        <p class="text-white/60">Gerencie tabelas de preços dinâmicas. Atualize valores e compartilhe com corretores.</p>
                    </div>
                    
                    {{-- Feature 5 --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <div class="w-14 h-14 rounded-2xl bg-blue-400/20 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Gestão de Equipe</h3>
                        <p class="text-white/60">Convide corretores e colaboradores. Defina permissões e acompanhe a performance.</p>
                    </div>
                    
                    {{-- Feature 6 --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <div class="w-14 h-14 rounded-2xl bg-pink-400/20 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">100% Responsivo</h3>
                        <p class="text-white/60">Acesse do celular, tablet ou computador. Funciona perfeitamente em qualquer dispositivo.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ========== COMO FUNCIONA ========== --}}
        <section id="como-funciona" class="py-20 lg:py-32 bg-gradient-to-b from-navy to-[#151926] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-coral font-semibold uppercase tracking-wider text-sm">Como funciona</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mt-4 mb-6">
                        Comece a usar em 3 passos
                    </h2>
                    <p class="text-lg text-white/60">
                        Sem complicação. Sem instalação. Apenas crie sua conta e comece.
                    </p>
                </div>
                
                {{-- Steps --}}
                <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                    {{-- Step 1 --}}
                    <div class="text-center">
                        <div class="number-badge mx-auto mb-6">1</div>
                        <h3 class="text-xl font-bold mb-3">Crie sua conta</h3>
                        <p class="text-white/60">Faça seu cadastro em menos de 1 minuto. Sem cartão de crédito.</p>
                    </div>
                    
                    {{-- Step 2 --}}
                    <div class="text-center">
                        <div class="number-badge mx-auto mb-6">2</div>
                        <h3 class="text-xl font-bold mb-3">Cadastre empreendimentos</h3>
                        <p class="text-white/60">Adicione seus projetos e unidades. Importe de planilhas se preferir.</p>
                    </div>
                    
                    {{-- Step 3 --}}
                    <div class="text-center">
                        <div class="number-badge mx-auto mb-6">3</div>
                        <h3 class="text-xl font-bold mb-3">Comece a vender</h3>
                        <p class="text-white/60">Crie propostas, acompanhe negociações e feche vendas.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ========== PREÇOS ========== --}}
        <section id="precos" class="py-20 lg:py-32 bg-[#151926] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-coral font-semibold uppercase tracking-wider text-sm">Preços</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mt-4 mb-6">
                        Planos que cabem no seu bolso
                    </h2>
                    <p class="text-lg text-white/60">
                        Escolha o plano ideal para o tamanho da sua operação. Todos incluem 15 dias grátis.
                    </p>
                </div>
                
                {{-- Pricing Cards --}}
                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    {{-- Starter --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <h3 class="text-xl font-bold mb-2">Starter</h3>
                        <p class="text-white/50 text-sm mb-6">Para quem está começando</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold">R$ 97</span>
                            <span class="text-white/50">/mês</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Até 2 empreendimentos
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Até 50 unidades
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                3 usuários
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Propostas ilimitadas
                            </li>
                        </ul>
                        <a href="/app/register" class="block text-center py-3 px-6 rounded-xl border border-white/20 text-white font-semibold hover:bg-white/5 transition-colors">
                            Começar grátis
                        </a>
                    </div>
                    
                    {{-- Profissional (Popular) --}}
                    <div class="card-lift relative gradient-card rounded-3xl p-8 border-2 border-coral">
                        <span class="popular-badge">Mais popular</span>
                        <h3 class="text-xl font-bold mb-2">Profissional</h3>
                        <p class="text-white/50 text-sm mb-6">Para construtoras em crescimento</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold">R$ 197</span>
                            <span class="text-white/50">/mês</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Até 10 empreendimentos
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Até 300 unidades
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                10 usuários
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Propostas ilimitadas
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Relatórios avançados
                            </li>
                        </ul>
                        <a href="/app/register" class="block text-center py-3 px-6 rounded-xl gradient-coral text-white font-semibold hover:opacity-90 transition-opacity">
                            Começar grátis
                        </a>
                    </div>
                    
                    {{-- Enterprise --}}
                    <div class="card-lift gradient-card rounded-3xl p-8 border border-white/10">
                        <h3 class="text-xl font-bold mb-2">Enterprise</h3>
                        <p class="text-white/50 text-sm mb-6">Para grandes operações</p>
                        <div class="mb-6">
                            <span class="text-4xl font-bold">R$ 497</span>
                            <span class="text-white/50">/mês</span>
                        </div>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Empreendimentos ilimitados
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Unidades ilimitadas
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Usuários ilimitados
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                API de integração
                            </li>
                            <li class="flex items-center gap-3 text-white/70">
                                <svg class="w-5 h-5 text-sage flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Suporte prioritário
                            </li>
                        </ul>
                        <a href="/app/register" class="block text-center py-3 px-6 rounded-xl border border-white/20 text-white font-semibold hover:bg-white/5 transition-colors">
                            Começar grátis
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ========== FAQ ========== --}}
        <section id="faq" class="py-20 lg:py-32 bg-navy relative">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center mb-16">
                    <span class="text-coral font-semibold uppercase tracking-wider text-sm">FAQ</span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mt-4 mb-6">
                        Perguntas frequentes
                    </h2>
                </div>
                
                {{-- FAQ Items --}}
                <div class="space-y-4">
                    {{-- FAQ 1 --}}
                    <details class="group gradient-card rounded-2xl border border-white/10 overflow-hidden">
                        <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                            <span class="font-semibold text-lg">Preciso instalar alguma coisa?</span>
                            <svg class="w-5 h-5 text-coral transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="px-6 pb-6 text-white/60">
                            Não! O Gestão e Proposta é 100% online. Basta criar sua conta e acessar pelo navegador do computador, tablet ou celular.
                        </div>
                    </details>
                    
                    {{-- FAQ 2 --}}
                    <details class="group gradient-card rounded-2xl border border-white/10 overflow-hidden">
                        <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                            <span class="font-semibold text-lg">Posso testar antes de pagar?</span>
                            <svg class="w-5 h-5 text-coral transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="px-6 pb-6 text-white/60">
                            Sim! Oferecemos 15 dias de teste grátis em todos os planos. Você só paga depois de testar e aprovar. Não pedimos cartão de crédito para o trial.
                        </div>
                    </details>
                    
                    {{-- FAQ 3 --}}
                    <details class="group gradient-card rounded-2xl border border-white/10 overflow-hidden">
                        <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                            <span class="font-semibold text-lg">Posso trocar de plano depois?</span>
                            <svg class="w-5 h-5 text-coral transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="px-6 pb-6 text-white/60">
                            Claro! Você pode fazer upgrade ou downgrade a qualquer momento. A diferença é calculada proporcionalmente.
                        </div>
                    </details>
                    
                    {{-- FAQ 4 --}}
                    <details class="group gradient-card rounded-2xl border border-white/10 overflow-hidden">
                        <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                            <span class="font-semibold text-lg">Meus dados ficam seguros?</span>
                            <svg class="w-5 h-5 text-coral transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="px-6 pb-6 text-white/60">
                            Sim! Usamos criptografia de ponta a ponta e servidores redundantes no Brasil. Seus dados são backupeados diariamente.
                        </div>
                    </details>
                    
                    {{-- FAQ 5 --}}
                    <details class="group gradient-card rounded-2xl border border-white/10 overflow-hidden">
                        <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                            <span class="font-semibold text-lg">Vocês oferecem treinamento?</span>
                            <svg class="w-5 h-5 text-coral transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="px-6 pb-6 text-white/60">
                            Sim! Todos os planos incluem acesso a tutoriais em vídeo e documentação. Nos planos Profissional e Enterprise, oferecemos onboarding personalizado.
                        </div>
                    </details>
                </div>
            </div>
        </section>

        {{-- ========== CTA FINAL ========== --}}
        <section class="py-20 lg:py-32 relative overflow-hidden">
            {{-- Background --}}
            <div class="absolute inset-0 gradient-coral opacity-10"></div>
            <div class="blob w-96 h-96 bg-coral/50 top-0 left-1/4"></div>
            
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6">
                    Pronto para vender mais?
                </h2>
                <p class="text-xl text-white/60 mb-10 max-w-2xl mx-auto">
                    Junte-se a construtoras que já simplificaram sua gestão de vendas. Comece grátis hoje.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/app/register" class="inline-flex items-center justify-center gap-2 gradient-coral text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:opacity-90 transition-opacity shadow-lg shadow-coral/25">
                        Criar conta grátis
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#precos" class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white/20 transition-colors">
                        Ver planos
                    </a>
                </div>
            </div>
        </section>
    </main>

    {{-- ========== FOOTER ========== --}}
    <footer class="py-12 bg-[#0D1017] border-t border-white/10" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg gradient-coral flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-white/70">Gestão e Proposta</span>
                </div>
                
                {{-- Links --}}
                <div class="flex items-center gap-8 text-sm text-white/50">
                    <a href="#" class="hover:text-white transition-colors">Termos de uso</a>
                    <a href="#" class="hover:text-white transition-colors">Privacidade</a>
                    <a href="#" class="hover:text-white transition-colors">Contato</a>
                </div>
                
                {{-- Copyright --}}
                <p class="text-sm text-white/40">
                    &copy; {{ date('Y') }} Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    {{-- ========== SCRIPTS ========== --}}
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('open');
        }
        
        // Header background on scroll
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('bg-navy/95', 'backdrop-blur-lg', 'border-b', 'border-white/10');
            } else {
                header.classList.remove('bg-navy/95', 'backdrop-blur-lg', 'border-b', 'border-white/10');
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
