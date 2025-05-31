<?php

namespace App\Http\Resources\Routes;

use App\DTOs\Route\ShowRouteDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ShowRouteDTO */
class RouteWithPOIsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'points' => $this->points->map(function ($point) {
                return [
                    'latitude' => $point->latitude,
                    'longitude' => $point->longtitude,
                ];
            })->toArray(),
        ];
    }
}
