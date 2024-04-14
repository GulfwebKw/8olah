<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property float $commission_per_work
 * @property string $bank_name
 * @property string $bank_number
 * @property string $bank_iban
 * @property boolean $is_admin
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'commission_per_work',
        'bank_name',
        'bank_number',
        'bank_iban',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'commission_per_work' => 'float',
            'is_admin' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        try {
            return $panel->getId() == "admin" ? $this->is_admin : !$this->is_admin;
        } catch (\Exception $e) {
            return false;
        }
    }
}
