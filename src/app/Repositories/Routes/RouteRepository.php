<?php

namespace App\Repositories\Routes;

use App\Models\Route;
use Illuminate\Database\Eloquent\Collection;

class RouteRepository
{
    public function getRoutesByType(string $type): Collection
    {
        return Route::query()->whereType($type)->get();
    }

    public function getWithPOIs(string $routeId): Route
    {
        return Route::query()->with('pointsOfInterest')->where('id', $routeId)->first();
    }
}
