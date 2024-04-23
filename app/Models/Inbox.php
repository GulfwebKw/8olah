<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string $message
 * @property boolean $seen
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Inbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seen',
        'message',
    ];

    protected $casts = [
        'seen' => 'boolean',
        'user_id' => 'int'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
