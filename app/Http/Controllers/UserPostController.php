<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use function App\Helpers\successfulResponse;

class UserPostController extends Controller
{
    /**
     * @throws Exception
     */
    public function like (Request $request, int $userId, int $postId) : Response|Application|ResponseFactory
    {
        try
        {
            DB::beginTransaction();
            $post = auth()->user()->posts()->where('post_id', 1)->first();
            if ($post == null)
            {
                auth()->user()->posts()->attach([$postId => ['is_like' => 1]]);
                $post = Post::findOrFail($postId);
                $post->increment('like_count');
            }
            else
            {
                auth()->user()->posts()->updateExistingPivot($postId, ['is_like' => DB::raw('!is_like')]);
                $post->{($post->pivot->is_like ? 'decrement' : 'increment')}('like_count');
            }
            DB::commit();
            return successfulResponse();
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            throw $exception;
        }
    }
}
