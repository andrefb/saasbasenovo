<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevelopmentAdjustment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'development_id',
        'adjustment_percent',
        'index_name',
        'notes',
        'applied_by',
        'applied_at',
    ];

    protected $casts = [
        'adjustment_percent' => 'decimal:2',
        'applied_at' => 'datetime',
    ];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }

    public function appliedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applied_by');
    }

    /**
     * Formata o percentual para exibição.
     */
    public function getFormattedPercentAttribute(): string
    {
        $sign = $this->adjustment_percent >= 0 ? '+' : '';
        return $sign . number_format($this->adjustment_percent, 2, ',', '.') . '%';
    }
}
