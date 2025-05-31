<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id - ID точки интереса
 * @property int $route_id - ID маршрута (внешний ключ)
 * @property Route $route - Маршрут к которому относится точка
 * @property float $longtitude - Долгота
 * @property float $latitude - Широта
 */
class PointOfInterest extends Model
{
    use HasFactory;

    protected $table = 'points_of_interest';

    protected $fillable = [
        'route_id',
        'longtitude',
        'latitude',
    ];

    // Связи
    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}
