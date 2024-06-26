<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'views' => $this->views,
            'full_name' => ($this->user->first_name . ' ' . $this->user->last_name),
            'user_id' => $this->user_id,
            'publish_date' => Carbon::parse($this->publish_date)->toDateString(),
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
