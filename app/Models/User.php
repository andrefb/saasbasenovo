<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Shared\Traits\HasPermissions;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;


class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'cpf',
        'is_active',
        'is_super_admin',
        'current_company_id',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_super_admin' => 'boolean',
        ];
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function currentCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'current_company_id');
    }

    public function invitationsSent()
    {
        return $this->hasMany(Invitation::class, 'inviter_id');
    }


    public function roles(): HasManyThrough
    {
        // Pega roles através do pivot
        // Útil para: $user->roles (todos os roles em todas companies)
        return $this->hasManyThrough(
            Role::class,
            CompanyUser::class,
            'user_id',
            'id',
            'id',
            'role_id'
        );
    }

    public function roleInCompany(int $companyId): ?Role
    {
        $pivot = $this->companies()
            ->where('company_id', $companyId)
            ->first()
            ?->pivot;

        return $pivot?->role;
    }

    public function companies(): BelongsToMany
    {


        return $this->belongsToMany(Company::class)
            ->using(CompanyUser::class) // Usa nossa Pivot customizada
            ->withPivot(['role_id', 'is_owner']); // Carrega dados extras
    }

    // Helper rápido para saber se tem alguma empresa
    public function hasCompany(): bool
    {
        return $this->companies()->exists();
    }


    public function canAccessPanel(Panel $panel): bool
    {


        if ($panel->getId() === 'admin') {
            return $this->is_super_admin
                && $this->is_active
                && $this->email === 'figueiraujo@gmail.com';
        }

        if ($panel->getId() === 'app') {
            return  $this->is_active;
        }

        return false;
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->companies;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->companies()->whereKey($tenant)->exists();
    }
}
