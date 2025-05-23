<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id - ID маршрута
 * @property string $type - Тип маршрута
 * @property string $title - Название маршрута
 * @property string $description - Описание маршрута
 */
class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
    ];

    // Связи
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function pointsOfInterest(): HasMany
    {
        return $this->hasMany(PointOfInterest::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
