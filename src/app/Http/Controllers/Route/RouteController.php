<?php

namespace App\Http\Controllers\Route;

use App\DTOs\Route\RoutesByTypeDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Routes\RouteResource;
use App\Services\Routes\RouteService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RouteController extends Controller
{
    public function __construct(
        private readonly RouteService $service
    ) {}

    public function getRoutesByType(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'type' => 'required|string',
        ]);

        $result = $this->service->getRoutesByType(RoutesByTypeDTO::fromArray($validated));

        return RouteResource::collection($result);
    }
}
