<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id - ID отзыва
 * @property int $user_id - ID пользователя (внешний ключ)
 * @property User $user - Пользователь написавший отзыв
 * @property int $route_id - ID маршрута (внешний ключ)
 * @property Route $route - Маршрут к которому написан отзыв
 * @property string $review_title - Заголовок отзыва
 * @property string $review_description - Текст отзыва
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'route_id',
        'review_title',
        'review_description',
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
}
