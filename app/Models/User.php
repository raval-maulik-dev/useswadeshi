<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'state',
        'country',
        'email_verified_at',
        'role',
        'password',
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
        ];
    }

    /**
     * Get the vendor associated with the user.
     */
    public function vendor(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    /**
     * Get the pledges made by the user.
     */
    public function pledges(): HasMany
    {
        return $this->hasMany(Pledge::class);
    }

    /**
     * Get the game results for the user.
     */
    public function gameResults(): HasMany
    {
        return $this->hasMany(GameResult::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == 'admin';
    }
}
