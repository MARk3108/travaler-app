<?php

namespace App\DTOs\Route;

class CreateRouteDTO
{
    public function __construct(
        public readonly string $type,
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $url=null,
        public readonly array $pois,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['type'],
            $data['title'],
            $data['description'],
            $data['url'] ?? null,
            $data['pois'],
        );
    }
}
