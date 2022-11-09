<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use App\Http\Resources\User\UserAuthorResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserInteractionResource;

class PostListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    #[ArrayShape(['title' => "mixed", 'content' => "mixed", 'viewCount' => "mixed", 'likeCount' => "mixed", 'shareCount' => "mixed", 'user' => "\App\Http\Resources\User\UserAuthorResource", 'userInteraction' => "\App\Http\Resources\User\UserInteractionResource", 'createdAt' => "mixed", 'updatedAt' => "mixed"])] public function toArray($request)
    {
        return [
            'title'           => $this->title,
            'content'         => $this->content,
            'viewCount'       => $this->view_count,
            'likeCount'       => $this->like_count,
            'shareCount'      => $this->share_count,
            'user'            => new UserAuthorResource($this->user),
            'userInteraction' => new UserInteractionResource(optional($this->users)[0]),
            'createdAt'       => $this->created_at,
            'updatedAt'       => $this->update_at,
        ];
    }
}
