<?php

namespace App\Http\Resources\Post;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use App\Http\Resources\User\UserAuthorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserInteractionResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray ($request) : array|JsonSerializable|Arrayable
    {
        return [
            'title'           => $this->title,
            'content'         => $this->content,
            'viewCount'       => $this->view_count,
            'likeCount'       => $this->like_count,
            'shareCount'      => $this->share_count,
            'user'            => new UserAuthorResource($this->user),
            'userInteraction' => $this->relationLoaded('users') ? new UserInteractionResource(optional($this->users)[0]) : null,
            'createdAt'       => $this->created_at,
            'updatedAt'       => $this->update_at,
        ];
    }
}
