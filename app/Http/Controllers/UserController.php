<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\Helpers\successfulResponse;

class UserController extends Controller
{
    private UserDTO $userDTO;

    /**
     * @param UserDTO $userDTO
     */
    public function __construct (UserDTO $userDTO)
    {
        $this->userDTO = $userDTO;

        if (request()->route()->getName() == 'me')
        {
            $this->middleware(['auth:sanctum'])->only(['show']);
        }
    }

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
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store (Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request  $request
     * @param int|null $id
     *
     * @return Response
     */
    public function show (Request $request, ?int $id = null) : Response
    {
        if ($id == null)
        {
            $user = auth()->user();
        }
        else
        {
            $user = User::findOrFail($id);
        }

        return successfulResponse(['user' => $this->userDTO->format($user)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return Response
     */
    public function update (Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy ($id)
    {
        //
    }
}
