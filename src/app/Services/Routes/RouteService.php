<?php

namespace App\Services\Routes;

use App\DTOs\POI\POIsListDTO;
use App\DTOs\Route\RoutesByTypeDTO;
use App\DTOs\Route\RouteWithPoiDTO;
use App\DTOs\Route\ShowRouteDTO;
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

    public function getRouteWithPOI(RouteWithPoiDTO $dto): ShowRouteDTO
    {
        $route = $this->routeRepository->getWithPOIs($dto->id);
        $points = $route->pointsOfInterest->map(fn ($point) => new POIsListDTO(
            latitude: $point->latitude,
            longtitude: $point->longtitude
        )
        );

        return new ShowRouteDTO(
            title: $route->title,
            points: $points,
        );
    }
}
