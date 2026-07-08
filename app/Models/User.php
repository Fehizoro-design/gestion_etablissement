<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'google_id', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the tenants (etablissements) this user can access.
     *
     * @return Collection<int, Etablissement>
     */
    public function getTenants(Panel $panel): Collection
    {
        return $this->etablissements()->get();
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->etablissements()->where('etablissements.id', $tenant->getKey())->exists();
    }

    /** @return HasMany<Etablissement, $this> */
    public function ownedEtablissements(): HasMany
    {
        return $this->hasMany(Etablissement::class);
    }

    /** @return BelongsToMany<Etablissement, $this> */
    public function etablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class, 'etablissement_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
