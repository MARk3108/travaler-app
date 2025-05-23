<?php

namespace App\DTOs\Route;

class RoutesByTypeDTO
{
    public function __construct(
        public readonly string $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['type'],
        );
    }
}
