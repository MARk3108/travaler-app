<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id - ID записи избранного
 * @property int $user_id - ID пользователя (внешний ключ)
 * @property User $user - Пользователь
 * @property int $route_id - ID маршрута (внешний ключ)
 * @property Route $route - Маршрут
 */
class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'route_id',
    ];

    // Связи
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function results(): HasOne
    {
        return $this->hasOne(Result::class);
    }
}
