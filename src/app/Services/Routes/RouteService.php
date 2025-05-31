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
    ) {}

    public function getRoutesByType(RoutesByTypeDTO $dto, int $userId): Collection
    {
        return $this->routeRepository->getRoutesByType($dto->type, $userId);
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
                'image_url' => $createRouteDTO->url,
            ]);

            foreach ($createRouteDTO->pois as $poi) {
                PointOfInterest::create([
                    'route_id' => $route->id,
                    'latitude' => $poi['latitude'],
                    'longtitude' => $poi['longitude'],
                ]);
            }
        } catch (Throwable $exception) {
            Log::info($exception->getMessage());
            throw new $exception;
        }
    }

    /**
     * Получает рекомендации маршрутов для пользователя
     *
     * @param  int  $userId  ID текущего пользователя
     * @param  int  $limit  Количество рекомендуемых маршрутов
     * @return Collection<int, Route>|null
     */
    public function getRecommendedRoutes(int $userId, int $limit = 10): ?Collection
    {
        // 1. Получаем избранные маршруты текущего пользователя
        $userFavorites = Favorite::where('user_id', $userId)
            ->where('status', true)
            ->pluck('route_id')
            ->toArray();

        // 2. Находим пользователей с наибольшим количеством общих избранных маршрутов
        $similarUsers = Favorite::where('status', true)
            ->where('user_id', '!=', $userId)
            ->whereIn('route_id', $userFavorites)
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(*) as common_count')
            ->orderByDesc('common_count')
            ->limit(10) // Берем топ-10 похожих пользователей
            ->pluck('user_id')
            ->toArray();

        // 3. Если нет похожих пользователей, возвращаем пустой массив
        if (empty($similarUsers)) {
            return null;
        }

        // 4. Собираем маршруты похожих пользователей, которых нет у текущего
        $recommendedRoutes = Favorite::where('status', true)
            ->whereIn('user_id', $similarUsers)
            ->whereNotIn('route_id', $userFavorites)
            ->groupBy('route_id')
            ->select('route_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit($limit)
            ->pluck('route_id')
            ->toArray();

        return Route::query()->whereIn('id', $recommendedRoutes)->get();

    }
}
