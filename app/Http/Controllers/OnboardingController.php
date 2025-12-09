<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function create()
    {
        return view('onboarding.create-company');
    }

    public function store(Request $request)
    {
        // 1. Validação
        $data = $request->validate([
            'name' => 'required|min:3|max:255',
            'slug' => 'required|alpha_dash|unique:companies,slug',
        ]);

        // 2. Cria a empresa
        $company = Company::create([
            'name' => $data['name'],
            'slug' => $data['slug'], // ou Str::slug($data['name'])
            'is_active' => true,
            'trial_ends_at' => now()->addDays(15),
        ]);

        // 3. Pega o Role de Owner (certifique-se que rodou o seeder ou criou no banco)
        $ownerRole = Role::where('key', 'owner')->first();

        // 4. Vincula o usuário
        Auth::user()->companies()->attach($company->id, [
            'role_id' => $ownerRole->id,
            'is_owner' => true,
        ]);

        // 5. Redireciona para o App da empresa recém-criada
        return redirect("/app/{$company->slug}");
    }
}
