<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Development extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'legal_name',
        'cnpj',
        'logo_url',
        'description',
        'website',
        'zip_code',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'is_active',
        'updated_by',
        // Condições de Pagamento
        'down_payment_percent',
        'monthly_percent',
        'monthly_installments',
        'annual_percent',
        'annual_installments',
        'keys_percent',
        'post_keys_percent',
        'post_keys_installments',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'down_payment_percent' => 'decimal:2',
        'monthly_percent' => 'decimal:2',
        'monthly_installments' => 'integer',
        'annual_percent' => 'decimal:2',
        'annual_installments' => 'integer',
        'keys_percent' => 'decimal:2',
        'post_keys_percent' => 'decimal:2',
        'post_keys_installments' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function adjustments(): HasMany
    {
        return $this->hasMany(DevelopmentAdjustment::class)->orderByDesc('applied_at');
    }
}
