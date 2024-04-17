<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property int $admin_id
 * @property User $admin
 * @property int $checkout_id
 * @property Checkout $checkout
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $description
 * @property string $admin_description
 * @property float $earn_commission
 * @property int $number_works
 * @property int $number_works_api
 * @property int $number_works_approved
 * @property boolean $is_earned
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Introduce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'checkout_id',
        'customer_name',
        'customer_phone',
        'description',
        'admin_description',
        'number_works',
        'number_works_api',
        'number_works_approved',
        'earn_commission',
        'is_earned',
    ];

    protected $casts = [
        'user_id' => 'int',
        'admin_id' => 'int',
        'checkout_id' => 'int',
        'number_works' => 'int',
        'number_works_api' => 'int',
        'number_works_approved' => 'int',
        'earn_commission' => 'float',
        'is_earned' => 'boolean',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class , 'admin_id');
    }

    public function checkout(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Checkout::class , 'checkout_id' , 'id');
    }
}
