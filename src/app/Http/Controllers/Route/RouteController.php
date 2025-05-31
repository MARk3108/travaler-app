<?php

namespace App\Http\Controllers\Route;

use App\DTOs\Route\RoutesByTypeDTO;
use App\DTOs\Route\RouteWithPoiDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Routes\RouteResource;
use App\Http\Resources\Routes\RouteWithPOIsResource;
use App\Services\Routes\RouteService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

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

    public function getRouteWithPOI(Request $request): RouteWithPOIsResource
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        $result = $this->service->getRouteWithPOI(RouteWithPoiDTO::fromArray($validated));
        Log::info($result->title);

        return new RouteWithPOIsResource($result);
    }
}
