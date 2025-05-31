<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupedTaskResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $tasks = $this->resource->resolve();
        return collect($tasks)
                ->groupBy('status')
                ->toArray();
    }
}
