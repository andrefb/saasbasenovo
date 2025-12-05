<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    protected $fillable = [
        'company_id',
        'inviter_id',
        'email',
        'role_id',
        'token',
        'expires_at',
        'accepted_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    // Empresa para a qual foi convidado
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Quem convidou
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    // Qual papel ele terá
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Scope útil para pegar apenas pendentes
    public function scopePending($query)
    {
        return $query->whereNull('accepted_at')
                     ->where('expires_at', '>', now());
    }

    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    public function isPending(): bool
    {
        return is_null($this->accepted_at) && !$this->isExpired();
    }

    public function markAsAccepted(): void
    {
        $this->update(['accepted_at' => now()]);
    }

    public static function canInvite(string $email, int $companyId): bool
        {
            // 1. Verifica se já é membro
            $user = User::where('email', $email)->first();
            if ($user && $user->companies()->where('company_id', $companyId)->exists()) {
                return false; // Já é membro
            }

            // 2. Verifica se tem convite pendente
            if (static::hasPendingFor($email, $companyId)) {
                return false; // Convite pendente
            }

            return true; // Pode convidar
        }
}
