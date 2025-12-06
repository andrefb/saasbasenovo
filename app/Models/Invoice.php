<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'company_id',
        'subscription_id',
        'amount',
        'currency',
        'status',
        'gateway_id',
        'gateway_pdf_url',
        'due_date',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'paid_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Helper para exibir valor formatado
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'R$ ' . number_format($this->amount / 100, 2, ',', '.')
        );
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
