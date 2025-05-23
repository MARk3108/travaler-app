<?php

namespace App\Models;

use App\EloquentBuilders\RouteBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id - ID маршрута
 * @property string $type - Тип маршрута
 * @property string $title - Название маршрута
 * @property string $description - Описание маршрута
 * @property string $image_url - Ссылка на изображение
 *
 * @method static RouteBuilder query()
 */
class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'description',
        'image_url',
    ];

    public function newEloquentBuilder($query): RouteBuilder
    {
        return new RouteBuilder($query);
    }

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
