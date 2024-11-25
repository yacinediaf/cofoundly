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
            'team' => new TeamResource($this->whenLoaded('team')),
            'tasks' => [
                'total' => $this->todo_tasks_count + $this->in_progress_tasks_count + $this->done_tasks_count,
                'todo' => $this->todo_tasks_count,
                'inProgress' => $this->in_progress_tasks_count,
                'done' => $this->done_tasks_count
            ]
        ];
    }
}
