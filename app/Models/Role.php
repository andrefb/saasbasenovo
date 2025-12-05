<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'key',
        'description',
        'default_permissions',
        'is_owner',
        'is_system',
        'sort_order',
    ];

    protected $casts = [
        'default_permissions' => 'array', // Converte JSON para Array PHP automaticamente
        'is_owner' => 'boolean',
        'is_system' => 'boolean',
    ];

    /**
     * Verifica se o Role possui uma permissão específica.
     * Suporta wildcard (ex: 'financial.*').
     */
    public function hasPermission(string $permissionKey): bool
    {
        // 1. Se é Owner, tem tudo
        if ($this->is_owner) {
            return true;
        }

        $permissions = $this->default_permissions ?? [];

        // 2. Verifica match exato
        if (in_array($permissionKey, $permissions)) {
            return true;
        }

        // 3. Verifica Wildcards (ex: 'financial.*' libera 'financial.create')
        foreach ($permissions as $perm) {
            if (str_ends_with($perm, '*')) {
                $category = str_replace('.*', '', $perm);
                if (str_starts_with($permissionKey, $category)) {
                    return true;
                }
            }

            // Wildcard global (raro, mas possível)
            if ($perm === '*') {
                return true;
            }
        }

        return false;
    }

    // Relação inversa: Quem tem esse perfil?
    // Note que passa pela tabela company_user
    public function companyUsers(): HasMany
    {
        return $this->hasMany(CompanyUser::class);
    }
}
