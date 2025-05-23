<?php

namespace App\Http\Resources\Routes;

use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Route */
class RouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'imageSrc' => $this->image_url,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
