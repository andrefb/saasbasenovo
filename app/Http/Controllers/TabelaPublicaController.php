<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Development;
use Illuminate\Http\Request;

class TabelaPublicaController extends Controller
{
    /**
     * Display the public sales table for a company (legacy - mock data).
     */
    public function show(string $slug)
    {
        $company = Company::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$company) {
            abort(404, 'Empresa não encontrada');
        }

        // Mock data for prototype - will be replaced with real data later
        $units = $this->getMockUnits();

        return view('public.tabela', [
            'company' => $company,
            'units' => $units,
        ]);
    }

    /**
     * Display the public sales table (version 2 - Google Style) for a company (legacy - mock data).
     */
    public function show2(string $slug)
    {
        $company = Company::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$company) {
            abort(404, 'Empresa não encontrada');
        }

        // Mock data for prototype - will be replaced with real data later
        $units = $this->getMockUnits();

        return view('public.tabela2', [
            'company' => $company,
            'units' => $units,
        ]);
    }

    /**
     * Display the public sales table for a specific development.
     * Uses real data from database.
     */
    public function showDevelopmentTable(string $companySlug, string $developmentSlug)
    {
        // 1. Buscar empresa
        $company = Company::where('slug', $companySlug)
            ->where('is_active', true)
            ->firstOrFail();

        // 2. Buscar empreendimento da empresa
        $development = Development::where('company_id', $company->id)
            ->where('slug', $developmentSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // 3. Buscar unidades ativas (eager loading já configurado no model)
        $query = $development->units()
            ->where('is_active', true);
            
        // Na tabela visual (nova), mostramos todas as unidades, inclusive vendidas
        // O filtro de vendidos fica apenas na tabela2 (lista de preços)

        $units = $query->orderBy('number')
            ->get();

        // 4. Mapear para estrutura esperada pelo template
        $unitsData = $units->map(fn ($unit) => [
            'id' => $unit->id,
            'unit' => $unit->number,
            'floor' => $unit->floor ?? '-',
            'position' => $unit->position ?? '-',
            'area' => (float) $unit->area,
            'price' => (float) $unit->price,
            'status' => $unit->status ?? 'available',
            'entry' => $unit->down_payment_value,
            'monthly' => [
                'count' => $development->monthly_installments ?? 0,
                'value' => $unit->monthly_installment_value,
            ],
            'annual' => [
                'count' => $development->annual_installments ?? 0,
                'value' => $unit->annual_installment_value,
            ],
            'keys' => $unit->keys_value,
            'post_keys' => [
                'count' => $development->post_keys_installments ?? 0,
                'value' => $unit->post_keys_installment_value,
            ],
            'floor_plan' => $unit->floor_plan_url ?? 'https://placehold.co/400x300/e2e8f0/64748b?text=Sem+Planta',
        ])->toArray();

        // 5. Agrupar unidades por andar para o grid visual (COM vendidos, se existirem)
        $unitsByFloor = collect($unitsData)->groupBy('floor')->toArray();

        // 6. Filtrar unidades para a lista de preços (SEM vendidos, se config assim determinar)
        if (!config('app.show_sold_units', true)) {
            $unitsData = array_filter($unitsData, fn($unit) => $unit['status'] !== 'sold');
        }

        return view('public.tabela', [
            'company' => $company,
            'development' => $development,
            'units' => $unitsData,
            'unitsByFloor' => $unitsByFloor,
        ]);
    }

    /**
     * Display the public sales table (version 2) for a specific development.
     * Uses real data from database.
     */
    public function showDevelopmentTable2(string $companySlug, string $developmentSlug)
    {
        // 1. Buscar empresa
        $company = Company::where('slug', $companySlug)
            ->where('is_active', true)
            ->firstOrFail();

        // 2. Buscar empreendimento da empresa
        $development = Development::where('company_id', $company->id)
            ->where('slug', $developmentSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // 3. Buscar unidades ativas
        $query = $development->units()
            ->where('is_active', true);

        // Filtrar vendidos se configurado
        if (!config('app.show_sold_units', true)) {
            $query->where('status', '!=', 'sold');
        }

        $units = $query->orderBy('number')
            ->get();

        // 4. Mapear para estrutura esperada pelo template
        $unitsData = $units->map(fn ($unit) => [
            'id' => $unit->id,
            'unit' => $unit->number,
            'floor' => $unit->floor ?? '-',
            'position' => $unit->position ?? '-',
            'area' => (float) $unit->area,
            'price' => (float) $unit->price,
            'status' => $unit->status ?? 'available',
            'entry' => $unit->down_payment_value,
            'monthly' => [
                'count' => $development->monthly_installments ?? 0,
                'value' => $unit->monthly_installment_value,
            ],
            'annual' => [
                'count' => $development->annual_installments ?? 0,
                'value' => $unit->annual_installment_value,
            ],
            'keys' => $unit->keys_value,
            'post_keys' => [
                'count' => $development->post_keys_installments ?? 0,
                'value' => $unit->post_keys_installment_value,
            ],
            'floor_plan' => $unit->floor_plan_url ?? 'https://placehold.co/400x300/e2e8f0/64748b?text=Sem+Planta',
        ])->toArray();

        return view('public.tabela2', [
            'company' => $company,
            'development' => $development,
            'units' => $unitsData,
        ]);
    }

    /**
     * Generate mock units for prototype.
     */
    private function getMockUnits(): array
    {
        return [
            [
                'id' => 1,
                'unit' => '101',
                'floor' => 'Térreo',
                'position' => 'Frente',
                'area' => 45.5,
                'price' => 350000,
                'status' => 'available',
                'entry' => 70000,
                'monthly' => ['count' => 24, 'value' => 2916.67],
                'annual' => ['count' => 3, 'value' => 23333.33],
                'keys' => 35000,
                'post_keys' => ['count' => 36, 'value' => 2916.67],
                'floor_plan' => 'https://placehold.co/400x300/e2e8f0/64748b?text=Planta+101',
            ],
            [
                'id' => 2,
                'unit' => '102',
                'floor' => 'Térreo',
                'position' => 'Fundos',
                'area' => 52.3,
                'price' => 420000,
                'status' => 'reserved',
                'entry' => 84000,
                'monthly' => ['count' => 24, 'value' => 3500],
                'annual' => ['count' => 3, 'value' => 28000],
                'keys' => 42000,
                'post_keys' => ['count' => 36, 'value' => 3500],
                'floor_plan' => 'https://placehold.co/400x300/e2e8f0/64748b?text=Planta+102',
            ],
            [
                'id' => 3,
                'unit' => '201',
                'floor' => '1º Andar',
                'position' => 'Frente',
                'area' => 48.0,
                'price' => 380000,
                'status' => 'sold',
                'entry' => 76000,
                'monthly' => ['count' => 24, 'value' => 3166.67],
                'annual' => ['count' => 3, 'value' => 25333.33],
                'keys' => 38000,
                'post_keys' => ['count' => 36, 'value' => 3166.67],
                'floor_plan' => 'https://placehold.co/400x300/e2e8f0/64748b?text=Planta+201',
            ],
            [
                'id' => 4,
                'unit' => '202',
                'floor' => '1º Andar',
                'position' => 'Fundos',
                'area' => 55.0,
                'price' => 450000,
                'status' => 'available',
                'entry' => 90000,
                'monthly' => ['count' => 24, 'value' => 3750],
                'annual' => ['count' => 3, 'value' => 30000],
                'keys' => 45000,
                'post_keys' => ['count' => 36, 'value' => 3750],
                'floor_plan' => 'https://placehold.co/400x300/e2e8f0/64748b?text=Planta+202',
            ],
            [
                'id' => 5,
                'unit' => '301',
                'floor' => '2º Andar',
                'position' => 'Frente',
                'area' => 60.0,
                'price' => 520000,
                'status' => 'available',
                'entry' => 104000,
                'monthly' => ['count' => 24, 'value' => 4333.33],
                'annual' => ['count' => 3, 'value' => 34666.67],
                'keys' => 52000,
                'post_keys' => ['count' => 36, 'value' => 4333.33],
                'floor_plan' => 'https://placehold.co/400x300/e2e8f0/64748b?text=Planta+301',
            ],
        ];
    }
}
