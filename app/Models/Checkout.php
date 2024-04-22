<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property int $admin_id
 * @property int $checkout_type_id
 * @property User $admin
 * @property Collection<Introduce> $Introduces
 * @property string $bank_name
 * @property string $bank_number
 * @property string $bank_iban
 * @property string $tracking_number
 * @property float $commission
 * @property string $picture
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'checkout_type_id',
        'bank_name',
        'bank_number',
        'bank_iban',
        'commission',
        'tracking_number',
        'picture',
    ];

    protected $casts = [
        'user_id' => 'int',
        'admin_id' => 'int',
        'checkout_type_id' => 'int',
        'commission' => 'float',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class , 'admin_id');
    }

    public function Introduces(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Introduce::class ,'checkout_id' ,'id');
    }

    public function checkout_type(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(CheckoutType::class ,'checkout_type_id' );
    }
}
