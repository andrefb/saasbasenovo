<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyUser extends Pivot
{
    // Indica que o ID da tabela é incremental (Laravel assume false para pivots por padrão)
    public $incrementing = true;

    protected $table = 'company_user';

    protected $fillable = [
        'company_id',
        'user_id',
        'role_id',
        'is_owner',
        'custom_permissions',
    ];

    protected $casts = [
        'is_owner' => 'boolean',
        'custom_permissions' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
