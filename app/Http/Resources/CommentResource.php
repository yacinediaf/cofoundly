<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => ProjectMembersResource::make($this->whenLoaded('user')),
            'content' => $this->content,
            'createdAt' => $this->created_at->diffForHumans()
        ];
    }
}
