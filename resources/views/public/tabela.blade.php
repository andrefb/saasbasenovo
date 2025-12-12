<x-layouts.public :title="$company->name . ' - Tabela de Vendas'">
    <div x-data="tabelaApp()" class="min-h-screen">

        {{-- Header --}}
        <header class="header-v4">
            <div class="header-inner">
                @if($company->logo_url)
                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="header-logo">
                @else
                    <span class="text-subtitle">{{ $company->name }}</span>
                @endif
            </div>
        </header>

        {{-- Page Header --}}
        <section class="page-header-v4">
            @if(isset($development) && $development->logo_url)
                <img src="{{ $development->logo_url }}" alt="{{ $development->name }}" class="dev-logo">
            @endif
            <h1 class="text-display">Tabela de Vendas</h1>

        </section>

        {{-- Visual Availability Grid --}}
        @if(isset($unitsByFloor) && count($unitsByFloor) > 0)
        <section class="availability-grid-section">
            @foreach($unitsByFloor as $floor => $floorUnits)
                <div class="floor-grid">
                    <h3 class="floor-title">{{ $floor }}</h3>
                    <div class="units-grid">
                        @foreach($floorUnits as $unit)
                            <div 
                                class="unit-cell unit-cell--{{ $unit['status'] }} {{ $unit['status'] !== 'sold' ? 'cursor-pointer' : '' }}"
                                @if($unit['status'] !== 'sold')
                                    @click="openDetails({{ json_encode($unit) }})"
                                @endif
                            >
                                <span class="unit-number">{{ $unit['unit'] }}</span>
                                @if($unit['status'] === 'sold')
                                    {{-- X hand-drawn style --}}
                                    <svg class="status-icon status-icon-x" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M5 5 L19 19 M5 6 L18 19" stroke-width="2.5" stroke-linecap="round"/>
                                        <path d="M19 5 L5 19 M18 6 L6 18" stroke-width="2.5" stroke-linecap="round"/>
                                    </svg>
                                @elseif($unit['status'] === 'reserved')
                                    {{-- Circle hand-drawn style --}}
                                    <svg class="status-icon status-icon-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <ellipse cx="12" cy="12" rx="8" ry="7.5" stroke-width="2.5" stroke-linecap="round"/>
                                    </svg>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>
        @endif

        {{-- Legend --}}
        <nav class="legend-v4">
            <div class="legend-item">
                <span class="legend-dot legend-dot-available"></span>
                Disponível
            </div>
            <div class="legend-item">
                <span class="legend-dot legend-dot-reserved"></span>
                Reservado
            </div>
            <div class="legend-item">
                <span class="legend-dot legend-dot-sold"></span>
                Vendido
            </div>
        </nav>

        {{-- Main Content --}}
        <main class="main-container">

            {{-- Desktop Table --}}
            <div class="table-wrapper">
                <table class="table-v4">
                    <thead>
                        <tr>
                            <th>Unidade</th>
                            <th class="text-right">Área (m²)</th>
                            <th class="text-right">Valor</th>
                            <th class="text-right">Entrada ({{ isset($development) ? rtrim(rtrim(number_format($development->down_payment_percent, 2), '0'), '.') : '30' }}%)</th>
                            <th class="text-right">Mensais ({{ isset($development) ? rtrim(rtrim(number_format($development->monthly_percent, 2), '0'), '.') : '20' }}%)</th>
                            <th class="text-right">Anuais ({{ isset($development) ? rtrim(rtrim(number_format($development->annual_percent, 2), '0'), '.') : '20' }}%)</th>
                            <th class="text-right">Chaves ({{ isset($development) ? rtrim(rtrim(number_format($development->keys_percent, 2), '0'), '.') : '10' }}%)</th>
                            <th class="text-right">Pós-Chaves ({{ isset($development) ? rtrim(rtrim(number_format($development->post_keys_percent, 2), '0'), '.') : '30' }}%)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                            <tr 
                                class="{{ $unit['status'] === 'sold' ? 'is-sold' : ($unit['status'] === 'reserved' ? 'is-reserved' : '') }} cursor-pointer"
                                @click="openDetails({{ json_encode($unit) }})"
                            >
                                {{-- Unit --}}
                                <td>
                                    <div class="cell-unit">
                                        <div class="cell-unit-info">
                                            <span class="cell-unit-number">{{ $unit['unit'] }}</span>
                                            <span class="cell-unit-location">{{ $unit['floor'] }} · {{ $unit['position'] }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Area --}}
                                <td class="text-right">
                                    <span class="cell-area">{{ number_format($unit['area'], 2, ',', '.') }}</span>
                                </td>

                                {{-- Price --}}
                                <td class="text-right">
                                    <span class="cell-price">R$ {{ number_format($unit['price'], 2, ',', '.') }}</span>
                                </td>

                                {{-- Entry --}}
                                <td class="text-right">
                                    <span class="cell-payment">R$ {{ number_format($unit['entry'], 2, ',', '.') }}</span>
                                </td>

                                {{-- Monthly --}}
                                <td class="text-right">
                                    <span class="cell-payment">{{ $unit['monthly']['count'] }}x R$ {{ number_format($unit['monthly']['value'], 2, ',', '.') }}</span>
                                </td>

                                {{-- Annual --}}
                                <td class="text-right">
                                    <span class="cell-payment">{{ $unit['annual']['count'] }}x R$ {{ number_format($unit['annual']['value'], 2, ',', '.') }}</span>
                                </td>

                                {{-- Keys --}}
                                <td class="text-right">
                                    <span class="cell-payment">R$ {{ number_format($unit['keys'], 2, ',', '.') }}</span>
                                </td>

                                {{-- Post Keys --}}
                                <td class="text-right">
                                    <span class="cell-payment">{{ $unit['post_keys']['count'] }}x R$ {{ number_format($unit['post_keys']['value'], 2, ',', '.') }}</span>
                                </td>

                                {{-- Status --}}
                                <td class="text-center">
                                    <span class="status-pill status-pill-{{ $unit['status'] }}">
                                        <span class="status-dot"></span>
                                        {{ $unit['status'] === 'sold' ? 'Vendido' : ($unit['status'] === 'reserved' ? 'Reservado' : 'Disponível') }}
                                    </span>
                                </td>

                                {{-- Action --}}
                                <td class="text-center">
                                    <button
                                        class="btn-icon"
                                        @click.stop="openDetails({{ json_encode($unit) }})"
                                        title="Ver detalhes"
                                    >
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="cards-grid">
                @foreach($units as $index => $unit)
                    <article
                        class="unit-card animate-in delay-{{ ($index % 5) + 1 }} {{ $unit['status'] === 'sold' ? 'is-sold' : ($unit['status'] === 'reserved' ? 'is-reserved' : '') }}"
                        @click="openDetails({{ json_encode($unit) }})"
                    >
                        <div class="card-header">
                            <img
                                src="{{ $unit['floor_plan'] }}"
                                alt="Planta {{ $unit['unit'] }}"
                                class="card-thumbnail"
                            >
                            <div class="card-info">
                                <div class="card-top-row">
                                    <span class="card-unit-number">{{ $unit['unit'] }}</span>
                                    <div class="card-status">
                                        <span class="status-pill status-pill-{{ $unit['status'] }}">
                                            <span class="status-dot"></span>
                                            {{ $unit['status'] === 'sold' ? 'Vendido' : ($unit['status'] === 'reserved' ? 'Reservado' : 'Disp.') }}
                                        </span>
                                    </div>
                                </div>
                                <p class="card-location">{{ $unit['floor'] }} · {{ $unit['position'] }}</p>
                                <span class="card-area">{{ number_format($unit['area'], 2, ',', '.') }} m²</span>
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="card-footer">
                            <div class="card-price-group">
                                <span class="card-price">R$ {{ number_format($unit['price'], 2, ',', '.') }}</span>
                                <span class="card-payment-hint">Entrada R$ {{ number_format($unit['entry'], 2, ',', '.') }}</span>
                            </div>
                            <button class="btn-details" @click.stop="openDetails({{ json_encode($unit) }})">
                                Detalhes
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Notas de Reajuste --}}
            <div class="reajuste-info">
                <ul>
                    <li>Reajuste durante obra: INCC ou CUB</li>
                    <li>Reajuste pós obra: IPCA + 1%</li>
                </ul>
            </div>

        </main>

        {{-- Footer --}}
        <footer class="footer-v4">
            <p class="footer-text">&copy; {{ date('Y') }} Todos os direitos reservados.</p>
        </footer>

        {{-- Details Modal --}}
        <div
            class="modal-overlay"
            :class="{ 'is-open': showDetails }"
            @click="closeDetails()"
            @keydown.escape.window="closeDetails()"
        >
            <div class="modal-content" @click.stop x-show="showDetails">

                {{-- Header --}}
                <div class="modal-header">
                    <img
                        :src="selectedUnit?.floor_plan"
                        :alt="'Planta ' + selectedUnit?.unit"
                        class="modal-thumbnail"
                        @click="openFloorPlan(selectedUnit?.floor_plan, selectedUnit?.unit)"
                    >
                    <div class="modal-title-group">
                        <h2 class="modal-unit-number">Unidade <span x-text="selectedUnit?.unit"></span></h2>
                        <p class="modal-location">
                            <span x-text="selectedUnit?.floor"></span> · <span x-text="selectedUnit?.position"></span>
                        </p>
                        <span class="modal-area">
                            <span x-text="selectedUnit?.area?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span> m²
                        </span>
                        
                        {{-- Status Badge in Modal --}}
                        <template x-if="selectedUnit?.status === 'reserved'">
                            <span class="status-pill status-pill-reserved" style="margin-left: 0.5rem;">
                                <span class="status-dot"></span>
                                Reservado
                            </span>
                        </template>
                        <template x-if="selectedUnit?.status === 'sold'">
                            <span class="status-pill status-pill-sold" style="margin-left: 0.5rem;">
                                <span class="status-dot"></span>
                                Vendido
                            </span>
                        </template>
                    </div>
                    <button class="modal-close" @click="closeDetails()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body">

                    {{-- Price --}}
                    <div class="price-section">
                        <p class="price-label">Valor Total</p>
                        <p class="price-value">R$ <span x-text="selectedUnit?.price?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></p>
                    </div>

                    {{-- Payment Conditions --}}
                    <h3 class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Condições de Pagamento
                    </h3>

                    <div class="payment-list">
                        {{-- Entrada --}}
                        <div class="payment-item">
                            <span class="payment-label">Entrada ({{ isset($development) ? rtrim(rtrim(number_format($development->down_payment_percent, 2), '0'), '.') : '30' }}%)</span>
                            <div class="text-right">
                                <span class="payment-value">R$ <span x-text="selectedUnit?.entry?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                            </div>
                        </div>

                        {{-- Mensais --}}
                        <div class="payment-item">
                            <span class="payment-label">Mensais ({{ isset($development) ? rtrim(rtrim(number_format($development->monthly_percent, 2), '0'), '.') : '20' }}%)</span>
                            <div class="text-right">
                                <span class="payment-value"><span x-text="selectedUnit?.monthly?.count"></span>x R$ <span x-text="selectedUnit?.monthly?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                                <p class="payment-installments">Total:&nbsp; R$ <span x-text="selectedUnit?.monthly?.total?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></p>
                            </div>
                        </div>

                        {{-- Anuais --}}
                        <div class="payment-item">
                            <span class="payment-label">Anuais ({{ isset($development) ? rtrim(rtrim(number_format($development->annual_percent, 2), '0'), '.') : '20' }}%)</span>
                            <div class="text-right">
                                <span class="payment-value"><span x-text="selectedUnit?.annual?.count"></span>x R$ <span x-text="selectedUnit?.annual?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                                <p class="payment-installments">Total:&nbsp; R$ <span x-text="selectedUnit?.annual?.total?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></p>
                            </div>
                        </div>

                        {{-- Chaves --}} 
                        <div class="payment-item">
                            <span class="payment-label">Chaves ({{ isset($development) ? rtrim(rtrim(number_format($development->keys_percent, 2), '0'), '.') : '10' }}%)</span>
                            <div class="text-right">
                                <span class="payment-value">R$ <span x-text="selectedUnit?.keys?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                            </div>
                        </div>

                        {{-- Pós-Chaves --}}
                        <div class="payment-item">
                            <span class="payment-label">Pós-Chaves ({{ isset($development) ? rtrim(rtrim(number_format($development->post_keys_percent, 2), '0'), '.') : '30' }}%)</span>
                            <div class="text-right">
                                <span class="payment-value"><span x-text="selectedUnit?.post_keys?.count"></span>x R$ <span x-text="selectedUnit?.post_keys?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                                <p class="payment-installments">Total:&nbsp; R$ <span x-text="selectedUnit?.post_keys?.total?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Floor Plan --}}
                    <h3 class="section-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Planta
                    </h3>

                    <div class="floor-plan-preview" @click="openFloorPlan(selectedUnit?.floor_plan, selectedUnit?.unit)">
                        <img :src="selectedUnit?.floor_plan" :alt="'Planta ' + selectedUnit?.unit">
                        <div class="floor-plan-overlay">
                            <span class="zoom-button">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                                Ampliar
                            </span>
                        </div>
                    </div>

                    <button class="btn-close-modal" @click="closeDetails()">Fechar</button>
                </div>
            </div>
        </div>

        {{-- Lightbox --}}
        <div
            class="lightbox"
            :class="{ 'is-open': showFloorPlan }"
            @click="closeFloorPlan()"
            @keydown.escape.window="closeFloorPlan()"
        >
            <div class="lightbox-content" @click.stop>
                <button class="lightbox-close" @click="closeFloorPlan()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <img :src="floorPlanImage" :alt="'Planta ' + floorPlanUnit">
                <p class="lightbox-title">Unidade <span x-text="floorPlanUnit"></span></p>
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
                    document.body.style.overflow = 'hidden';
                    // Reset scroll do modal para o topo
                    this.$nextTick(() => {
                        const modal = document.querySelector('.modal-content');
                        if (modal) modal.scrollTop = 0;
                    });
                },

                closeDetails() {
                    this.showDetails = false;
                    document.body.style.overflow = '';
                },

                openFloorPlan(imageUrl, unitName) {
                    this.floorPlanImage = imageUrl;
                    this.floorPlanUnit = unitName;
                    this.showFloorPlan = true;
                    // Modal de detalhes permanece aberto (empilhado)
                },

                closeFloorPlan() {
                    this.showFloorPlan = false;
                    document.body.style.overflow = '';
                }
            }
        }
    </script>
</x-layouts.public>

