<?php

namespace App\DTOs\POI;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class POIsListDTO extends Data
{
    public function __construct(
        public float $latitude,
        public float $longtitude,
    ) {}
}
