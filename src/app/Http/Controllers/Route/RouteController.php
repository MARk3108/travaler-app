<?php

namespace App\Http\Controllers\Route;

use App\DTOs\Route\CreateRouteDTO;
use App\DTOs\Route\FavoriteRouteDTO;
use App\DTOs\Route\RoutesByTypeDTO;
use App\DTOs\Route\RouteWithPoiDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Routes\RouteResource;
use App\Http\Resources\Routes\RouteWithPOIsResource;
use App\Models\Route;
use App\Services\Routes\RouteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Throwable;

class RouteController extends Controller
{
    public function __construct(
        private readonly RouteService $service
    ) {}

    public function getRoutesByType(Request $request): AnonymousResourceCollection
    {
        $user = $request->user();
        $validated = $request->validate([
            'type' => 'required|string',
        ]);

        $result = $this->service->getRoutesByType(RoutesByTypeDTO::fromArray($validated), $user->id);

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

    public function addToFavorite(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);
        try {
            $user = $request->user();
            $this->service->addToFavorite(FavoriteRouteDTO::fromArray($validated, $user->id));
            $category = Route::query()->findOrFail($validated['id'])->type;

            return response()->json($category);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Route not found'], 404);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    public function createNewRoute(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'url' => 'nullable|string',
            'pois' => 'required|array',
        ]);
        try {
            $this->service->createNewRoute(CreateRouteDTO::fromArray($validated));

            return response()->json(200);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    public function getRecomendations(Request $request): AnonymousResourceCollection
    {
        try {
            $user = $request->user();
            $result = $this->service->getRecommendedRoutes($user->id);
            if ($result === null || $result->isEmpty()) {
                return RouteResource::collection(collect([]))
                    ->additional([
                        'message' => 'No recommendations found',
                        'success' => true,
                    ]);
            }

            return RouteResource::collection($result);
        } catch (Throwable $exception) {
            return RouteResource::collection(collect([]))
                ->additional([
                    'message' => 'Error '.$exception->getMessage(),
                    'success' => false,
                ]);
        }

    }
}
