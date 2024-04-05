<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'body' => $this->body,
                'full_name' => $this->user->first_name . ' ' . $this->user->last_name,
                'user_id' => $this->user_id,
                'created_at' => $this->created_at->diffForHumans(),
            ];
    }
}
