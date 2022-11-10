<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserAuthorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserInteractionResource;

class PostListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray ($request) : array
    {
        return [
            'id'              => $this->id,
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
