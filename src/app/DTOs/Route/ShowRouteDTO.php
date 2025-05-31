<?php

namespace App\DTOs\Route;

use App\DTOs\POI\POIsListDTO;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class ShowRouteDTO extends Data
{
    /**
     * @param  Collection<POIsListDTO>  $points
     */
    public function __construct(
        public string $title,
        public Collection $points,
    ) {}
}
