<?php

namespace App\DTOs\Route;

class FavoriteRouteDTO
{
    public function __construct(
        public readonly int $id,
        public readonly bool $status,
        public readonly int $userId
    ) {}

    public static function fromArray(array $data, int $userId): self
    {
        return new self(
            $data['id'],
            $data['status'],
            $userId
        );
    }
}
