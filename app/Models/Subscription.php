<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'plan_id',
        'status',
        'gateway_id',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'canceled_at',
        'current_period_start',
        'current_period_end',
        'metadata',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'canceled_at' => 'datetime',
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'metadata' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Verifica se a assinatura está válida (ativa ou em período de graça após cancelamento).
     */
    public function isValid(): bool
    {
        return $this->status === 'active' || $this->onGracePeriod();
    }

    /**
     * Verifica se está cancelada mas ainda dentro do período pago.
     */
    public function onGracePeriod(): bool
    {
        return $this->canceled_at && $this->current_period_end?->isFuture();
    }

    /**
     * Verifica se está em trial.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }
}
