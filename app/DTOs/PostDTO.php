<?php

namespace App\DTOs;

use App\Models\Post;

class PostDTO
{
    public function format (Post $post)
    {
        return [
            'id'        => $post->id,
            'title'     => $post->title,
            'content'   => $post->content,
            'createdAt' => $post->created_at,
            'updateAt'  => $post->update_at,
            'user'      => [
                'id'   => $post->user->id,
                'name' => $post->user->name,
            ],
        ];
    }
}