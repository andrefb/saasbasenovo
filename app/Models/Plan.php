<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'price',
        'currency',
        'interval',
        'interval_count',
        'trial_days',
        'features',
        'gateway_id',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array', // JSON para Array
        'is_active' => 'boolean',

    ];

    // Helper para exibir preço formatado (R$ 29,90)
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'R$ ' . number_format($this->price / 100, 2, ',', '.')
        );
    }

    // Helper para buscar feature específica (Ex: $plan->getFeature('max_users'))
    public function getFeature(string $key, mixed $default = null): mixed
    {
        return $this->features[$key] ?? $default;
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
