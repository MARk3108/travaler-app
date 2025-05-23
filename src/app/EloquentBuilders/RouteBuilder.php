<?php

namespace App\EloquentBuilders;

use Illuminate\Database\Eloquent\Builder;

class RouteBuilder extends Builder
{
    public function whereType(string $type): self
    {
        return $this->where('type', $type);
    }
}
