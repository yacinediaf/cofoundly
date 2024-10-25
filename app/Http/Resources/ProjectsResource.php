<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'projectCode' => $this->project_code,
            'title' => $this->title,
            'description' => $this->whenNotNull($this->description),
            'projectImage' => $this->project_image_path,
            'status' => $this->status,
            'createdAt' => $this->created_at->diffForHumans(),
            'udpatedAt' => $this->updated_at->diffForHumans(),
            'team' => new TeamResource($this->whenLoaded('team'))
        ];
    }
}
