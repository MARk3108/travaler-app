<?php

namespace App\Services\Routes;

use App\DTOs\Route\RoutesByTypeDTO;
use App\Repositories\Routes\RouteRepository;
use Illuminate\Database\Eloquent\Collection;

class RouteService
{
    public function __construct(
        private RouteRepository $routeRepository,
    ) {}

    public function getRoutesByType(RoutesByTypeDTO $dto): Collection
    {
        return $this->routeRepository->getRoutesByType($dto->type);
    }
}
