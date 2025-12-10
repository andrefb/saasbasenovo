<x-layouts.public2 :title="$company->name . ' - Tabela de Vendas'">
    <div x-data="tabelaApp()" class="min-h-screen bg-[var(--color-background)]">
        
        {{-- Header - Google Style --}}
        <header class="bg-[var(--color-card)] border-b border-[var(--color-border)] sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    {{-- Logo e Nome --}}
                    <div class="flex items-center gap-3">
                        @if($company->logo_url)
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="header-logo">
                        @else
                            <div class="w-10 h-10 rounded-full bg-[var(--color-primary-light)] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                        <span class="text-lg font-medium text-[var(--color-foreground)]">{{ $company->name }}</span>
                    </div>
                    
                    {{-- Link Entrar - Google Style --}}
                    <a href="{{ url('/app/' . $company->slug) }}" class="link-enter">
                        Entrar
                    </a>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="max-w-7xl mx-auto px-4 py-6 sm:py-8">
            
            {{-- Status Legend - Chips --}}
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mb-6">
                <div class="chip">
                    <span class="w-2 h-2 rounded-full bg-[var(--color-success)]"></span>
                    Disponível
                </div>
                <div class="chip">
                    <span class="w-2 h-2 rounded-full bg-[var(--color-warning)]"></span>
                    Reservado
                </div>
                <div class="chip">
                    <span class="w-2 h-2 rounded-full bg-[var(--color-destructive)]"></span>
                    Vendido
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
                                <tr class="border-b border-[var(--color-border)] last:border-0 hover:bg-[var(--color-muted)]/50 transition-colors {{ $unit['status'] === 'sold' ? 'row-sold' : ($unit['status'] === 'reserved' ? 'row-reserved' : '') }}">
                                    <td class="px-4 py-4 font-medium text-[var(--color-foreground)]">{{ $unit['unit'] }}</td>
                                    <td class="px-4 py-4 text-[var(--color-muted-foreground)]">{{ $unit['floor'] }}</td>
                                    <td class="px-4 py-4 text-[var(--color-muted-foreground)]">{{ $unit['position'] }}</td>
                                    <td class="px-4 py-4 text-right">{{ number_format($unit['area'], 2, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right font-medium text-[var(--color-primary)]">
                                        R$ {{ number_format($unit['price'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 text-right text-sm text-[var(--color-muted-foreground)]">R$ {{ number_format($unit['entry'], 2, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-right text-sm text-[var(--color-muted-foreground)]">
                                        {{ $unit['monthly']['count'] }}x R$ {{ number_format($unit['monthly']['value'], 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <button 
                                            @click="openFloorPlan('{{ $unit['floor_plan'] }}', '{{ $unit['unit'] }}')"
                                            class="mx-auto block"
                                        >
                                            <img src="{{ $unit['floor_plan'] }}" alt="Planta {{ $unit['unit'] }}" class="thumbnail-plant">
                                        </button>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex items-center justify-center">
                                            <button
                                                @click="openDetails({{ json_encode($unit) }})"
                                                class="p-2 rounded-full hover:bg-[var(--color-muted)] text-[var(--color-muted-foreground)] hover:text-[var(--color-primary)] transition-colors"
                                                title="Ver detalhes"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            {{-- Mobile Cards - Google Style --}}
            <div class="lg:hidden space-y-3">
                @foreach($units as $unit)
                    <div class="card-elevated overflow-hidden animate-slide-up relative {{ $unit['status'] === 'sold' ? 'card-status-sold' : ($unit['status'] === 'reserved' ? 'card-status-reserved' : 'card-status-available') }}">
                        
                        {{-- Status Badge - Pill style --}}
                        @if($unit['status'] !== 'available')
                            <div class="status-ribbon {{ $unit['status'] === 'sold' ? 'status-ribbon-sold' : 'status-ribbon-reserved' }}">
                                {{ $unit['status'] === 'sold' ? 'Vendido' : 'Reservado' }}
                            </div>
                        @endif
                        
                        <div class="flex gap-4 p-4">
                            {{-- Thumbnail --}}
                            <button
                                @click="openFloorPlan('{{ $unit['floor_plan'] }}', '{{ $unit['unit'] }}')"
                                class="shrink-0"
                            >
                                <img src="{{ $unit['floor_plan'] }}" alt="Planta {{ $unit['unit'] }}" class="card-thumbnail">
                            </button>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0 {{ $unit['status'] !== 'available' ? 'pt-6' : '' }}">
                                <h3 class="text-base font-medium text-[var(--color-foreground)] mb-1">
                                    Unidade {{ $unit['unit'] }}
                                </h3>
                                <div class="flex items-center gap-2 text-sm text-[var(--color-muted-foreground)] mb-2">
                                    <span>{{ $unit['floor'] }}</span>
                                    <span>•</span>
                                    <span>{{ $unit['position'] }}</span>
                                </div>

                                <div class="chip chip-primary mb-3">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                    </svg>
                                    {{ number_format($unit['area'], 2, ',', '.') }} m²
                                </div>

                                <div>
                                    <p class="text-lg font-medium text-[var(--color-primary)]">
                                        R$ {{ number_format($unit['price'], 2, ',', '.') }}
                                    </p>
                                    <button
                                        @click="openDetails({{ json_encode($unit) }})"
                                        class="flex items-center gap-1 text-sm text-[var(--color-primary)] font-medium hover:underline mt-1"
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

        {{-- Footer - Clean --}}
        <footer class="border-t border-[var(--color-border)] bg-[var(--color-card)] mt-12">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <p class="text-center text-sm text-[var(--color-muted-foreground)]">
                    © {{ date('Y') }} {{ $company->name }}. Todos os direitos reservados.
                </p>
            </div>
        </footer>

        {{-- Details Modal --}}
        <div x-show="showDetails" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="modal-overlay animate-fade-in" 
             @click="showDetails = false"
             style="display: none;">
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div 
                    x-show="showDetails"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-97"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="modal-content w-full max-w-2xl p-5 sm:p-6"
                    @click.stop
                >
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <h2 class="text-xl font-medium text-[var(--color-foreground)]">
                                Unidade <span x-text="selectedUnit?.unit"></span>
                            </h2>
                            <div class="flex items-center gap-2 mt-1 text-sm text-[var(--color-muted-foreground)]">
                                <span x-text="selectedUnit?.floor"></span>
                                <span>•</span>
                                <span x-text="selectedUnit?.position"></span>
                            </div>
                        </div>
                        <button
                            @click="showDetails = false"
                            class="p-2 rounded-full hover:bg-[var(--color-muted)] transition-colors text-[var(--color-muted-foreground)]"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 mb-5">
                        <div class="p-4 rounded-2xl bg-[var(--color-muted)]">
                            <p class="text-xs text-[var(--color-muted-foreground)] mb-1 uppercase tracking-wide">Área privativa</p>
                            <p class="text-lg font-medium text-[var(--color-foreground)]">
                                <span x-text="selectedUnit?.area?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span> m²
                            </p>
                        </div>
                        <div class="p-4 rounded-2xl bg-[var(--color-primary-light)]">
                            <p class="text-xs text-[var(--color-primary)] mb-1 uppercase tracking-wide">Preço total</p>
                            <p class="text-xl font-medium text-[var(--color-primary)]">
                                R$ <span x-text="selectedUnit?.price?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h3 class="text-xs font-medium text-[var(--color-muted-foreground)] mb-3 uppercase tracking-wide">Condições de Pagamento</h3>
                        <div class="space-y-2 bg-[var(--color-muted)] rounded-2xl p-4">
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Entrada (20%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    R$ <span x-text="selectedUnit?.entry?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-t border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Mensais (20%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    <span x-text="selectedUnit?.monthly?.count"></span>x R$ <span x-text="selectedUnit?.monthly?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-t border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Anual (20%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    <span x-text="selectedUnit?.annual?.count"></span>x R$ <span x-text="selectedUnit?.annual?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-t border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Chaves (10%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    R$ <span x-text="selectedUnit?.keys?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-t border-[var(--color-border)]">
                                <span class="text-sm text-[var(--color-muted-foreground)]">Pós-chaves (30%)</span>
                                <span class="text-sm font-medium text-[var(--color-foreground)]">
                                    <span x-text="selectedUnit?.post_keys?.count"></span>x R$ <span x-text="selectedUnit?.post_keys?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h3 class="text-xs font-medium text-[var(--color-muted-foreground)] mb-3 uppercase tracking-wide">Planta</h3>
                        <button
                            @click="openFloorPlan(selectedUnit?.floor_plan, selectedUnit?.unit)"
                            class="w-full rounded-2xl overflow-hidden border border-[var(--color-border)] hover:border-[var(--color-primary)] transition-colors group"
                        >
                            <div class="aspect-video relative">
                                <img :src="selectedUnit?.floor_plan" :alt="'Planta da unidade ' + selectedUnit?.unit" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-white px-4 py-2 rounded-full flex items-center gap-2 shadow-lg">
                                        <svg class="w-4 h-4 text-[var(--color-primary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                        </svg>
                                        <span class="text-sm font-medium">Ampliar</span>
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
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="modal-overlay" 
             @click="showFloorPlan = false"
             style="display: none;">
            <div class="fixed inset-0 flex items-center justify-center p-4">
                <div 
                    x-show="showFloorPlan"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-97"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="modal-content w-full max-w-4xl p-4"
                    @click.stop
                >
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-medium text-[var(--color-foreground)]">
                            Planta - Unidade <span x-text="floorPlanUnit"></span>
                        </h2>
                        <button
                            @click="showFloorPlan = false"
                            class="p-2 rounded-full hover:bg-[var(--color-muted)] transition-colors text-[var(--color-muted-foreground)]"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="rounded-2xl overflow-hidden">
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
</x-layouts.public2>
