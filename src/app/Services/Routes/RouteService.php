<?php

namespace App\Services\Routes;

use App\DTOs\POI\POIsListDTO;
use App\DTOs\Route\CreateRouteDTO;
use App\DTOs\Route\FavoriteRouteDTO;
use App\DTOs\Route\RoutesByTypeDTO;
use App\DTOs\Route\RouteWithPoiDTO;
use App\DTOs\Route\ShowRouteDTO;
use App\Models\Favorite;
use App\Models\PointOfInterest;
use App\Models\Route;
use App\Repositories\Routes\RouteRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class RouteService
{
    public function __construct(
        private RouteRepository $routeRepository,
    )
    {
    }

    public function getRoutesByType(RoutesByTypeDTO $dto, int $userId): Collection
    {
        return $this->routeRepository->getRoutesByType($dto->type, $userId);
    }

    public function getRouteWithPOI(RouteWithPoiDTO $dto): ShowRouteDTO
    {
        $route = $this->routeRepository->getWithPOIs($dto->id);
        $points = $route->pointsOfInterest->map(fn($point) => new POIsListDTO(
            latitude: $point->latitude,
            longtitude: $point->longtitude
        )
        );

        return new ShowRouteDTO(
            title: $route->title,
            points: $points,
        );
    }

    public function addToFavorite(FavoriteRouteDTO $favoriteRouteDTO): void
    {
        try {
            Favorite::create([
                'user_id' => $favoriteRouteDTO->userId,
                'route_id' => $favoriteRouteDTO->id,
                'status' => $favoriteRouteDTO->status,
            ]);
        } catch (Throwable $exception) {
            throw new $exception;
        }
    }

    public function createNewRoute(CreateRouteDTO $createRouteDTO): void
    {
        try {
            $route = Route::create([
                'title' => $createRouteDTO->title,
                'description' => $createRouteDTO->description,
                'type' => $createRouteDTO->type,
                'image_url' => $createRouteDTO->url
            ]);

            foreach ($createRouteDTO->pois as $poi) {
                PointOfInterest::create([
                    'route_id' => $route->id,
                    'latitude' => $poi['latitude'],
                    'longtitude' => $poi['longitude'],
                ]);
            }
        }catch (Throwable $exception){
            Log::info($exception->getMessage());
            throw new $exception;
        }
    }
}
