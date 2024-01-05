<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        'isAdmin',
    ];


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    public function hasRole(string $roleName)
    {
        return filled($roleName) ? $this->roles()->where('name', $roleName)->exists() : false;
    }

    public function hasAnyRole(array|string $roleName, string ...$roleNames)
    {
        $roleNames = array_filter(
            array_merge((array) $roleName, $roleNames),
            fn($value) => is_string($value) && filled($value)
        );

        return filled($roleNames) ? $this->roles()->whereIn('name', $roleNames)->exists() : false;
    }
}
