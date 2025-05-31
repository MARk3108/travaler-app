<?php

namespace App\Repositories\Routes;

use App\Models\Route;
use Illuminate\Database\Eloquent\Collection;

class RouteRepository
{
    public function getRoutesByType(string $type, int $userId): Collection
    {
        return Route::query()->whereType($type)
            ->whereDoesntHave('favorites', function ($query) use ($userId): void {
                $query->where('user_id', $userId);
            })
            ->get();
    }

    public function getWithPOIs(string $routeId): Route
    {
        return Route::query()->with('pointsOfInterest')->where('id', $routeId)->first();
    }
}
