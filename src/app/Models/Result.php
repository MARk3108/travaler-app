<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id - ID результата
 * @property int $favorite_id - ID избранного
 * @property Favorite $favorite - Модель избранной записи
 * @property int $score - Количество часов проведенных в дороге
 */
class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'favorite_id',
        'score',
    ];

    // Связи
    public function favorite(): BelongsTo
    {
        return $this->belongsTo(Favorite::class);
    }
}
