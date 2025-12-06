<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'logo_url',
        'slug',
        'legal_name',
        'cnpj',
        'inscricao_estadual',
        'email',
        'phone_1',
        'phone_2',
        'website',
        'zip_code',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'is_active',
        'trial_ends_at',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'trial_ends_at' => 'datetime',
    ];

    /**
     * Verifica se a empresa está em período de trial.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    // Relacionamento M:N com Users (usando o Pivot customizado)
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->using(CompanyUser::class)
                    ->withPivot(['role_id', 'is_owner']) // Campos extras da tabela pivot
                    ->withTimestamps();
    }

    // Convites pendentes desta empresa
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    // Assinatura (One-to-One geralmente, ou Many se tiver histórico)
        public function subscription(): HasOne
        {
            return $this->hasOne(Subscription::class)
                        ->where('status', 'active')
                        ->orWhere('status', 'trial');
        }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
