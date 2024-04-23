<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $company_name
 * @property string $avatar
 * @property string $username
 * @property string $email
 * @property string $password
 * @property float $commission_per_work
 * @property string $bank_name
 * @property string $bank_number
 * @property string $bank_iban
 * @property boolean $is_admin
 * @property boolean $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements FilamentUser,HasAvatar,HasName
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'company_name',
        'avatar',
        'username',
        'email',
        'password',
        'commission_per_work',
        'bank_name',
        'bank_number',
        'bank_iban',
        'is_admin',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        try {
            return ($panel->getId() == "admin" ? $this->is_admin : !$this->is_admin) and  $this->is_active;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar ? asset('storage/'.$this->avatar) : null;
    }

    public function getFilamentName(): string
    {
        return  $this->is_admin ? $this->name : $this->company_name .' ('.$this->name.')';
    }
}
