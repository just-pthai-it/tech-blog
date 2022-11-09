<?php

namespace App\DTOs;

use App\Models\Post;

class PostDTO
{
    public function format (Post $post) : array
    {
        $userDTO = new UserDTO();
        return [
            'id'        => $post->id,
            'title'     => $post->title,
            'content'   => $post->content,
            'createdAt' => $post->created_at,
            'updateAt'  => $post->update_at,
            'user'      => $userDTO->formatAuthor($post->user),
        ];
    }

    public function formatGet (Post $post) : array
    {
        $userDTO = new UserDTO();

        return [
            'title'      => $post->title,
            'content'    => $post->content,
            'viewCount'  => $post->view_count,
            'likeCount'  => $post->like_count,
            'shareCount' => $post->share_count,
            'user'       => $userDTO->formatAuthor($post->user),
            'createdAt'  => $post->created_at,
            'updatedAt'  => $post->update_at,
        ];
    }
}