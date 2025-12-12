<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'development_id',
        'number',
        'floor',
        'position',
        'status',
        'area',
        'price',
        'original_price',
        'floor_plan_url',
        'description',
        'is_active',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'area' => 'decimal:2',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    // Eager loading para evitar N+1
    protected $with = ['development'];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ==========================================
    // ACCESSORS - Valores calculados de pagamento
    // Todos arredondados para 2 casas decimais (regra financeira)
    // ==========================================

    public function getDownPaymentValueAttribute(): float
    {
        $percent = $this->development?->down_payment_percent ?? 0;
        return round((float) $this->price * ($percent / 100), 2);
    }

    public function getMonthlyValueAttribute(): float
    {
        $percent = $this->development?->monthly_percent ?? 0;
        return round((float) $this->price * ($percent / 100), 2);
    }

    public function getMonthlyInstallmentValueAttribute(): float
    {
        $installments = $this->development?->monthly_installments ?? 0;
        if ($installments <= 0) return 0;
        return round($this->monthly_value / $installments, 2);
    }

    public function getAnnualValueAttribute(): float
    {
        $percent = $this->development?->annual_percent ?? 0;
        return round((float) $this->price * ($percent / 100), 2);
    }

    public function getAnnualInstallmentValueAttribute(): float
    {
        $installments = $this->development?->annual_installments ?? 0;
        if ($installments <= 0) return 0;
        return round($this->annual_value / $installments, 2);
    }

    public function getKeysValueAttribute(): float
    {
        $percent = $this->development?->keys_percent ?? 0;
        return round((float) $this->price * ($percent / 100), 2);
    }

    public function getPostKeysValueAttribute(): float
    {
        $percent = $this->development?->post_keys_percent ?? 0;
        return round((float) $this->price * ($percent / 100), 2);
    }

    public function getPostKeysInstallmentValueAttribute(): float
    {
        $installments = $this->development?->post_keys_installments ?? 0;
        if ($installments <= 0) return 0;
        return round($this->post_keys_value / $installments, 2);
    }
}
