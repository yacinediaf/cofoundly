<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class TaskResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->whenNotNull($this->description),
            'status' => $this->status,
            'assignedTo' => $this->assignedTo,
            'createdAt' => $this->created_at->diffForHumans(),
            'updatedAt' => $this->updated_at->diffForHumans(),
            'assignedat' => $this->assigned_at,
            'deliveryDate' => $this->delivery_date->diffForHumans(),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'can' => [
                'editTask' => Gate::check('edit-task', $this->resource),
                'deleteTask' => Gate::check('delete-task', $this->resource)
            ]
        ];
    }
}
