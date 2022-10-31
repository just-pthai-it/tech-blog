<?php

namespace App\DTOs;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UserDTO
{
    public function format (User|Authenticatable $user) : array
    {
        return [
            'id'             => $user->id,
            'name'           => $user->name,
            'nickname'       => $user->nickname,
            'email'          => $user->email,
            'birth'          => $user->birth,
            'gender'         => $user->gender,
            'role'           => $user->role,
            'followerCount'  => $user->follower_count,
            'followingCount' => $user->following_count,
            'trendingPoint'  => $user->trending_point,
        ];
    }
}