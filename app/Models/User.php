<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Cek apakah user memiliki role/identitas Kasir.
     */
    public function isKasir(): bool
    {
        if (strtolower($this->email) === 'cashier@gmail.com') {
            return true;
        }

        if (isset($this->role) && is_object($this->role)) {
            $roleName = strtolower($this->role->name ?? '');
            if ($roleName === 'cashier' || $roleName === 'kasir') {
                return true;
            }
        }

        if ($this->role_id) {
            $role = Role::find($this->role_id);
            if ($role) {
                $roleName = strtolower($role->name);
                if ($roleName === 'cashier' || $roleName === 'kasir') {
                    return true;
                }
            }
        }

        return str_contains(strtolower($this->email), 'cashier') || str_contains(strtolower($this->email), 'kasir');
    }

    /**
     * Cek apakah user memiliki role/identitas Pimpinan.
     */
    public function isPimpinan(): bool
    {
        if (strtolower($this->email) === 'pimpinan@gmail.com' || strtolower($this->email) === 'manager@gmail.com') {
            return true;
        }

        if (isset($this->role) && is_object($this->role)) {
            $roleName = strtolower($this->role->name ?? '');
            if ($roleName === 'pimpinan' || $roleName === 'manager') {
                return true;
            }
        }

        if ($this->role_id) {
            $role = Role::find($this->role_id);
            if ($role) {
                $roleName = strtolower($role->name);
                if ($roleName === 'pimpinan' || $roleName === 'manager') {
                    return true;
                }
            }
        }

        return str_contains(strtolower($this->email), 'pimpinan') || str_contains(strtolower($this->email), 'manager');
    }
}
