<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

/**
 * Trait para garantir isolamento de dados por tenant.
 * 
 * Use esse trait em qualquer Model que pertença a uma Company.
 * Automaticamente filtra todas as queries pelo company_id do tenant atual.
 * 
 * Requisitos:
 * - O model deve ter uma coluna 'company_id'
 * - Deve ser usado dentro do contexto do Filament com tenant ativo
 */
trait BelongsToTenant
{
    /**
     * Boot the trait.
     * Adiciona global scope que filtra por company_id.
     */
    public static function bootBelongsToTenant(): void
    {
        // Adiciona filtro automático em todas as queries
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenant = Filament::getTenant();
            
            if ($tenant) {
                $builder->where(static::getTableName() . '.company_id', $tenant->id);
            }
        });

        // Ao criar um novo registro, define automaticamente o company_id
        static::creating(function ($model) {
            $tenant = Filament::getTenant();
            
            if ($tenant && empty($model->company_id)) {
                $model->company_id = $tenant->id;
            }
        });
    }

    /**
     * Retorna o nome da tabela do model.
     * Necessário para evitar ambiguidade em joins.
     */
    protected static function getTableName(): string
    {
        return (new static)->getTable();
    }

    /**
     * Scope para queries sem o filtro de tenant.
     * Use com cuidado! Apenas para admin ou operações especiais.
     * 
     * Exemplo: Model::withoutTenantScope()->get()
     */
    public function scopeWithoutTenantScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }

    /**
     * Verifica se o registro pertence ao tenant atual.
     */
    public function belongsToCurrentTenant(): bool
    {
        $tenant = Filament::getTenant();
        
        if (!$tenant) {
            return false;
        }

        return $this->company_id === $tenant->id;
    }

    /**
     * Relationship com a Company (tenant).
     */
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }
}
