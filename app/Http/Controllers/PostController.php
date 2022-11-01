<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\DTOs\PostDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CreatePostPostRequest;
use App\Http\Requests\UpdatePostPatchRequest;
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
    public function __construct (PostDTO $postDTO) { $this->postDTO = $postDTO; }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index ()
    {
        //
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
        Post::create(array_merge($request->validated(), ['user_id' => auth()->user()->id]));
        return successfulResponse([], '', HTTP_STATUS_CODE_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function show (Request $request, int $id) : Response
    {

        $post = Post::where([['id', $id], ['mode', 1]])->first();

        if ($post != null)
        {
            return successfulResponse($this->postDTO->format($post));
        }

        return failedResponse([], 'Not Found', HTTP_STATUS_CODE_NOT_FOUND);
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
