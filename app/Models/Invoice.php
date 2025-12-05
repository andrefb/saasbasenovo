<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
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
    ];

    // Helper para exibir valor formatado
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'R$ ' . number_format($this->amount / 100, 2, ',', '.')
        );
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

            protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }
}
