<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'role',
        'status',
        'notes',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'status' => 'string',
    ];

    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPerusahaan(): bool
    {
        return $this->role === 'perusahaan';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function updateLastLogin()
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
    }

    public function activate()
    {
        $this->update(['status' => 'active']);
    }

    public function deactivate()
    {
        $this->update(['status' => 'inactive']);
    }

    public function getRoleNameAttribute()
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'perusahaan' => 'Perusahaan',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'danger',
            default => 'secondary',
        };
    }
}
