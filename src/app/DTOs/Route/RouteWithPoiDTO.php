<?php

namespace App\DTOs\Route;

class RouteWithPoiDTO
{
    public function __construct(
        public readonly int $id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
        );
    }
}
