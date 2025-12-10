<x-layouts.public :title="$company->name . ' - Tabela de Vendas'">
    <div x-data="tabelaApp()" class="min-h-screen bg-[var(--color-background)]">
        
        {{-- Header --}}
        <header class="bg-[var(--color-card)] border-b border-[var(--color-border)] sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($company->logo_url)
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-[var(--color-primary-light)] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                        <span class="text-lg font-semibold text-[var(--color-foreground)]">{{ $company->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="max-w-7xl mx-auto px-4 py-6 sm:py-8">
            
            {{-- Hero Section --}}
            <div class="mb-8 text-center sm:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[var(--color-primary-light)] text-[var(--color-primary)] text-sm font-medium mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Tabela de Vendas
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-[var(--color-foreground)] mb-2">
                    {{ $company->name }}
                </h1>
                <p class="text-[var(--color-muted-foreground)] max-w-2xl">
                    Veja as unidades disponíveis, preços e condições de pagamento.
                </p>
            </div>

            {{-- Status Legend --}}
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 sm:gap-6 mb-6 text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[var(--color-success)]"></span>
                    <span class="text-[var(--color-muted-foreground)]">Disponível</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[var(--color-warning)]"></span>
                    <span class="text-[var(--color-muted-foreground)]">Reservado</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[var(--color-destructive)]"></span>
                    <span class="text-[var(--color-muted-foreground)]">Vendido</span>
                </div>
            </div>

            {{-- Desktop Table --}}
            <div class="card-elevated overflow-hidden animate-slide-up hidden lg:block mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="table-header border-b border-[var(--color-border)]">
                                <th class="text-left px-4 py-3">Unidade</th>
                                <th class="text-left px-4 py-3">Andar</th>
                                <th class="text-left px-4 py-3">Posição</th>
                                <th class="text-right px-4 py-3">Área (m²)</th>
                                <th class="text-right px-4 py-3">Preço</th>
                                <th class="text-right px-4 py-3">Entrada (20%)</th>
                                <th class="text-right px-4 py-3">Mensais (20%)</th>
                                <th class="text-center px-4 py-3">Planta</th>
                                <th class="text-center px-4 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($units as $unit)
                                <tr class="border-b border-[var(--color-border)] last:border-0 hover:bg-[var(--color-muted)]/30 transition-colors {{ $unit['status'] === 'sold' ? 'row-sold' : ($unit['status'] === 'reserved' ? 'row-reserved' : '') }}">
                                    <td class="px-4 py-3 font-medium text-[var(--color-foreground)]">{{ $unit['unit'] }}</td>
                                    <td class="px-4 py-3 text-[var(--color-muted-foreground)]">{{ $unit['floor'] }}</td>
                                    <td class="px-4 py-3 text-[var(--color-muted-foreground)]">{{ $unit['position'] }}</td>
                                    <td class="px-4 py-3 text-right font-medium">{{ number_format($unit['area'], 1, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-[var(--color-primary)]">
                                        R$ {{ number_format($unit['price'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm">R$ {{ number_format($unit['entry'], 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-right text-sm">
                                        {{ $unit['monthly']['count'] }}x R$ {{ number_format($unit['monthly']['value'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <button 
                                            @click="openFloorPlan('{{ $unit['floor_plan'] }}', '{{ $unit['unit'] }}')"
                                            class="w-12 h-12 mx-auto rounded-lg overflow-hidden border border-[var(--color-border)] hover:border-[var(--color-primary)] transition-colors block"
                                        >
                                            <img src="{{ $unit['floor_plan'] }}" alt="Planta {{ $unit['unit'] }}" class="w-full h-full object-cover">
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                @click="openDetails({{ json_encode($unit) }})"
                                                class="p-2 rounded-lg hover:bg-[var(--color-muted)] text-[var(--color-muted-foreground)] hover:text-[var(--color-foreground)] transition-colors"
                                                title="Ver detalhes"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mobile Cards --}}
            <div class="lg:hidden space-y-4">
                @foreach($units as $unit)
                    <div class="card-elevated p-4 animate-slide-up relative overflow-hidden {{ $unit['status'] === 'sold' ? 'row-sold' : ($unit['status'] === 'reserved' ? 'row-reserved' : '') }}">
                        
                        {{-- Status Ribbon --}}
                        @if($unit['status'] !== 'available')
                            <div class="absolute -left-8 top-4 z-10">
                                <div class="{{ $unit['status'] === 'sold' ? 'bg-[var(--color-destructive)] text-white' : 'bg-[var(--color-warning)] text-[var(--color-warning-foreground)]' }} text-xs font-medium px-8 py-1 -rotate-45 shadow-sm">
                                    {{ $unit['status'] === 'sold' ? 'Vendido' : 'Reservado' }}
                                </div>
                            </div>
                        @endif
                        
                        <div class="flex gap-4">
                            <button
                                @click="openFloorPlan('{{ $unit['floor_plan'] }}', '{{ $unit['unit'] }}')"
                                class="shrink-0 w-20 h-20 rounded-lg overflow-hidden border border-[var(--color-border)] hover:border-[var(--color-primary)] transition-colors"
                            >
                                <img src="{{ $unit['floor_plan'] }}" alt="Planta {{ $unit['unit'] }}" class="w-full h-full object-cover">
                            </button>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h3 class="text-lg font-semibold text-[var(--color-foreground)]">
                                            Unidade {{ $unit['unit'] }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-sm text-[var(--color-muted-foreground)] mt-0.5">
                                            <span>{{ $unit['floor'] }}</span>
                                            <span>•</span>
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $unit['position'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 text-sm mb-3">
                                    <span class="flex items-center gap-1 text-[var(--color-muted-foreground)]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                        {{ number_format($unit['area'], 1, ',', '.') }} m²
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-bold text-[var(--color-primary)]">
                                        R$ {{ number_format($unit['price'], 2, ',', '.') }}
                                    </p>
                                    <button
                                        @click="openDetails({{ json_encode($unit) }})"
                                        class="flex items-center gap-1 text-sm text-[var(--color-primary)] font-medium hover:opacity-80 transition-colors"
                                    >
                                        Ver detalhes
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-[var(--color-border)] bg-[var(--color-card)] mt-12">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <p class="text-center text-sm text-[var(--color-muted-foreground)]">
                    © {{ date('Y') }} {{ $company->name }}. Todos os direitos reservados.
                </p>
            </div>
        </footer>

        {{-- Details Modal --}}
        <div x-show="showDetails" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="modal-overlay animate-fade-in" 
             @click="showDetails = false"
             style="display: none;">
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div 
                    x-show="showDetails"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="modal-content w-full max-w-2xl p-4 sm:p-6"
                    @click.stop
                >
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-[var(--color-foreground)] flex items-center gap-2">
                                <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Unidade <span x-text="selectedUnit?.unit"></span>
                            </h2>
                            <div class="flex items-center gap-2 mt-1 text-[var(--color-muted-foreground)]">
                                <span x-text="selectedUnit?.floor"></span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    <span x-text="selectedUnit?.position"></span>
                                </span>
                            </div>
                        </div>
                        <button
                            @click="showDetails = false"
                            class="p-2 rounded-lg hover:bg-[var(--color-muted)] transition-colors text-[var(--color-muted-foreground)] hover:text-[var(--color-foreground)]"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 mb-6">
                        <div class="p-4 rounded-lg bg-[var(--color-muted)]/50 border border-[var(--color-border)]">
                            <div class="flex items-center gap-2 text-[var(--color-muted-foreground)] text-sm mb-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                Área privativa
                            </div>
                            <p class="text-lg font-semibold text-[var(--color-foreground)]">
                                <span x-text="selectedUnit?.area?.toLocaleString('pt-BR', {minimumFractionDigits: 1})"></span> m²
                            </p>
                        </div>
                        <div class="p-4 rounded-lg bg-[var(--color-primary-light)] border border-[var(--color-primary)]/20">
                            <p class="text-sm text-[var(--color-muted-foreground)] mb-1">Preço total</p>
                            <p class="text-xl font-bold text-[var(--color-primary)]">
                                R$ <span x-text="selectedUnit?.price?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-[var(--color-foreground)] mb-3">Condições de Pagamento</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between py-2 border-b border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Entrada (20%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    R$ <span x-text="selectedUnit?.entry?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Mensais (20%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    <span x-text="selectedUnit?.monthly?.count"></span>x R$ <span x-text="selectedUnit?.monthly?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Anual (20%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    <span x-text="selectedUnit?.annual?.count"></span>x R$ <span x-text="selectedUnit?.annual?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Chaves (10%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    R$ <span x-text="selectedUnit?.keys?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Pós-chaves (30%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    <span x-text="selectedUnit?.post_keys?.count"></span>x R$ <span x-text="selectedUnit?.post_keys?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-[var(--color-foreground)] mb-3">Planta</h3>
                        <button
                            @click="openFloorPlan(selectedUnit?.floor_plan, selectedUnit?.unit)"
                            class="w-full rounded-lg overflow-hidden border border-[var(--color-border)] hover:border-[var(--color-primary)]/50 transition-colors group"
                        >
                            <div class="aspect-video relative">
                                <img :src="selectedUnit?.floor_plan" :alt="'Planta da unidade ' + selectedUnit?.unit" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Ver em tamanho maior</span>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>

                    <button
                        @click="showDetails = false"
                        class="w-full btn-secondary"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </div>

        {{-- Floor Plan Modal --}}
        <div x-show="showFloorPlan"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="modal-overlay" 
             @click="showFloorPlan = false"
             style="display: none;">
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div 
                    x-show="showFloorPlan"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="modal-content w-full max-w-4xl p-4"
                    @click.stop
                >
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-[var(--color-foreground)]">
                            Planta - Unidade <span x-text="floorPlanUnit"></span>
                        </h2>
                        <button
                            @click="showFloorPlan = false"
                            class="p-2 rounded-lg hover:bg-[var(--color-muted)] transition-colors text-[var(--color-muted-foreground)] hover:text-[var(--color-foreground)]"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="rounded-lg overflow-hidden">
                        <img :src="floorPlanImage" :alt="'Planta da unidade ' + floorPlanUnit" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function tabelaApp() {
            return {
                showDetails: false,
                showFloorPlan: false,
                selectedUnit: null,
                floorPlanImage: '',
                floorPlanUnit: '',
                
                openDetails(unit) {
                    this.selectedUnit = unit;
                    this.showDetails = true;
                },
                
                openFloorPlan(imageUrl, unitName) {
                    this.floorPlanImage = imageUrl;
                    this.floorPlanUnit = unitName;
                    this.showFloorPlan = true;
                    this.showDetails = false;
                }
            }
        }
    </script>
</x-layouts.public>
