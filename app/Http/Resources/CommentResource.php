<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'post_id' => $this->post_id,
            'post_title' => $this->post->title,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at->format('Y-m-d H:m:i'),
        ];
    }
}
