<?php

namespace App\DTOs;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UserDTO
{
    public function formatLogin (User|Authenticatable $user) : array
    {
        return [
            'id'            => $user->id,
            'name'          => $user->name,
            'nickname'      => $user->nickname,
            'email'         => $user->email,
            'githubEmail'   => $user->github_email,
            'facebookEmail' => $user->facebook_email,
            'googleEmail'   => $user->google_email,
        ];
    }

    public function formatAuthor (User $user) : array
    {
        return [
            'id'             => $user->id,
            'name'           => $user->name,
            'nickname'       => $user->nickname,
            'birth'          => $user->birth,
            'gender'         => $user->gender,
            'bio'            => $user->bio,
            'work'           => $user->work,
            'education'      => $user->geeducationnder,
            'codingSkills'   => $user->coding_skills,
            'followerCount'  => $user->follower_count,
            'followingCount' => $user->following_count,
            'createdAt'      => $user->created_at,
        ];
    }

    public function formatGet (User $user) : array
    {
        return [
            'id'             => $user->id,
            'name'           => $user->name,
            'nickname'       => $user->nickname,
            'email'          => $user->email,
            'birth'          => $user->birth,
            'gender'         => $user->gender,
            'bio'            => $user->bio,
            'work'           => $user->work,
            'education'      => $user->geeducationnder,
            'codingSkills'   => $user->coding_skills,
            'followerCount'  => $user->follower_count,
            'followingCount' => $user->following_count,
            'trendingPoint'  => $user->trending_point,
            'githubEmail'    => $user->github_email,
            'facebookEmail'  => $user->facebook_email,
            'googleEmail'    => $user->google_email,
        ];
    }
}