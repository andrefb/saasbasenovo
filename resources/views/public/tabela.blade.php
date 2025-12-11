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
            <h1 class="text-display">Tabela de Disponibilidade e Venda</h1>

        </section>

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
                            <th class="text-right">Área</th>
                            <th class="text-right">Valor</th>
                            <th class="text-right">Entrada</th>
                            <th class="text-right">Mensais</th>
                            <th class="text-center">Status</th>
                            <th class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                            <tr class="{{ $unit['status'] === 'sold' ? 'is-sold' : ($unit['status'] === 'reserved' ? 'is-reserved' : '') }}">
                                {{-- Unit --}}
                                <td>
                                    <div class="cell-unit">
                                        <img
                                            src="{{ $unit['floor_plan'] }}"
                                            alt="Planta {{ $unit['unit'] }}"
                                            class="cell-thumbnail"
                                            @click="openFloorPlan('{{ $unit['floor_plan'] }}', '{{ $unit['unit'] }}')"
                                        >
                                        <div class="cell-unit-info">
                                            <span class="cell-unit-number">{{ $unit['unit'] }}</span>
                                            <span class="cell-unit-location">{{ $unit['floor'] }} · {{ $unit['position'] }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Area --}}
                                <td class="text-right">
                                    <span class="cell-area">{{ number_format($unit['area'], 2, ',', '.') }} m²</span>
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
                                        @click="openDetails({{ json_encode($unit) }})"
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
            <p class="footer-text">&copy; {{ date('Y') }} {{ $company->name }}. Todos os direitos reservados.</p>
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
                            <span class="payment-label">Entrada ({{ isset($development) ? $development->down_payment_percent : 20 }}%)</span>
                            <div class="text-right">
                                <span class="payment-value">R$ <span x-text="selectedUnit?.entry?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                            </div>
                        </div>

                        {{-- Mensais --}}
                        <div class="payment-item">
                            <span class="payment-label">Mensais ({{ isset($development) ? $development->monthly_percent : 20 }}%)</span>
                            <div class="text-right">
                                <span class="payment-value">R$ <span x-text="selectedUnit?.monthly?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                                <p class="payment-installments"><span x-text="selectedUnit?.monthly?.count"></span> parcelas</p>
                            </div>
                        </div>

                        {{-- Anuais --}}
                        <div class="payment-item">
                            <span class="payment-label">Anuais ({{ isset($development) ? $development->annual_percent : 20 }}%)</span>
                            <div class="text-right">
                                <span class="payment-value">R$ <span x-text="selectedUnit?.annual?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                                <p class="payment-installments"><span x-text="selectedUnit?.annual?.count"></span> parcelas</p>
                            </div>
                        </div>

                        {{-- Chaves --}}
                        <div class="payment-item">
                            <span class="payment-label">Chaves ({{ isset($development) ? $development->keys_percent : 10 }}%)</span>
                            <div class="text-right">
                                <span class="payment-value">R$ <span x-text="selectedUnit?.keys?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                            </div>
                        </div>

                        {{-- Pós-Chaves --}}
                        <div class="payment-item">
                            <span class="payment-label">Pós-Chaves ({{ isset($development) ? $development->post_keys_percent : 30 }}%)</span>
                            <div class="text-right">
                                <span class="payment-value">R$ <span x-text="selectedUnit?.post_keys?.value?.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span></span>
                                <p class="payment-installments"><span x-text="selectedUnit?.post_keys?.count"></span> parcelas</p>
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
                },

                closeDetails() {
                    this.showDetails = false;
                    document.body.style.overflow = '';
                },

                openFloorPlan(imageUrl, unitName) {
                    this.floorPlanImage = imageUrl;
                    this.floorPlanUnit = unitName;
                    this.showFloorPlan = true;
                    this.showDetails = false;
                },

                closeFloorPlan() {
                    this.showFloorPlan = false;
                    document.body.style.overflow = '';
                }
            }
        }
    </script>
</x-layouts.public>

