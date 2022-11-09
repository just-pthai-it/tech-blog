<?php

namespace App\Http\Resources\User;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthorResource extends JsonResource
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
            'id'             => $this->id,
            'name'           => $this->name,
            'nickname'       => $this->nickname,
            'birth'          => $this->birth,
            'gender'         => $this->gender,
            'bio'            => $this->bio,
            'work'           => $this->work,
            'education'      => $this->geeducationnder,
            'codingSkills'   => $this->coding_skills,
            'followerCount'  => $this->follower_count,
            'followingCount' => $this->following_count,
            'createdAt'      => $this->created_at,
        ];
    }
}
