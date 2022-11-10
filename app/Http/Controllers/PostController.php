<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\DTOs\PostDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostListResource;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Post\CreatePostPostRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\Post\UpdatePostPatchRequest;
use function App\Helpers\failedResponse;
use function App\Helpers\successfulResponse;
use const App\Helpers\HTTP_STATUS_CODE_CREATED;
use const App\Helpers\HTTP_STATUS_CODE_NOT_FOUND;

class PostController extends Controller
{
    private PostDTO $postDTO;

    /**
     * @param PostDTO $postDTO
     */
    public function __construct (PostDTO $postDTO)
    {
        $this->postDTO = $postDTO;

        $this->middleware(['auth:sanctum'])->only(['store', 'update', 'destroy']);
        if (request()->header('Authorization') != null)
        {
            $this->middleware(['auth:sanctum'])->only(['index', 'show']);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Application|ResponseFactory|Response
     */
    public function index () : Response|Application|ResponseFactory
    {
        if (auth()->user() == null)
        {
            $result = Post::latest()->with(['user'])->paginate(25);
        }
        else
        {
            $result = Post::latest()->with(['users' => function ($query)
            {
                $query->where('user_id', auth()->user()->id);
            }, 'user'])->paginate(25);
        }

        return successfulResponse(PostListResource::collection($result)->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePostPostRequest $request
     *
     * @return Response
     */
    public function store (CreatePostPostRequest $request) : Response
    {
        $post = Post::create(array_merge($request->validated(), ['user_id' => auth()->user()->id]));
        return successfulResponse(['id' => $post->id], '', HTTP_STATUS_CODE_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function show (Request $request, int $id)
    {
        if (auth()->user() == null)
        {
            $post = Post::where([['id', $id], ['mode', 1]])->first();
        }
        else
        {
            $post = Post::where([['id', $id], ['mode', 1]])
                        ->with(['users' => function ($query)
                        {
                            $query->where('user_id', auth()->user()->id);
                        }])->first();
        }

        if ($post == null)
        {
            return failedResponse([], 'Not Found', HTTP_STATUS_CODE_NOT_FOUND);
        }

        return successfulResponse((new PostResource($post)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostPatchRequest $request
     * @param int                    $id
     *
     * @return Response
     */
    public function update (UpdatePostPatchRequest $request, int $id) : Response
    {
        try
        {
            Post::findOrFail($id)->update($request->validated());
            return successfulResponse();
        }
        catch (Exception $exception)
        {
            return failedResponse([], 'Not found', HTTP_STATUS_CODE_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function destroy (Request $request, int $id) : Response
    {
        try
        {
            Post::findOrFail($id)->delete();
            return successfulResponse();
        }
        catch (Exception $exception)
        {
            return failedResponse([], 'Not found', HTTP_STATUS_CODE_NOT_FOUND);
        }
    }
}
