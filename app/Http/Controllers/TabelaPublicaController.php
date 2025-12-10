<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class TabelaPublicaController extends Controller
{
    /**
     * Display the public sales table for a company.
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
