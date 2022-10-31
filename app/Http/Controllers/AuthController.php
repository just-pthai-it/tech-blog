<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Http\Response;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use function App\Helpers\failedResponse;
use function App\Helpers\successfulResponse;
use const App\Helpers\HTTP_STATUS_CODE_UNAUTHORIZED;
use const App\Helpers\HTTP_STATUS_CODE_UNAUTHORIZED_THIRD_PARTY;

class AuthController extends Controller
{
    private UserDTO $userDTO;

    /**
     * @param UserDTO $userDTO
     */
    public function __construct (UserDTO $userDTO) { $this->userDTO = $userDTO; }


    public function login (LoginPostRequest $request,
                           ?string          $option = null) : Response|Application|ResponseFactory
    {
        if ($option == 'third-party')
        {
            $user = User::where('github', $request->third_party_id)
                        ->orWhere('facebook', $request->third_party_id)
                        ->orWhere('google', $request->third_party_id)->first();
            if ($user == null)
            {
                $data = ['redirectUrl' => route('register', ['option' => 'third-party'])];
                return failedResponse($data, '', HTTP_STATUS_CODE_UNAUTHORIZED_THIRD_PARTY);
            }

            $accessToken = $user->createToken('access_token')->plainTextToken;
            $data        = [
                'user'        => $this->userDTO->format($user),
                'accessToken' => $accessToken,
            ];
            return successfulResponse($data);
        }

        if (auth()->attempt($request->validated()))
        {
            $accessToken = auth()->user()->createToken('access_token')->plainTextToken;
            $data        = [
                'user'        => $this->userDTO->format(auth()->user()),
                'accessToken' => $accessToken,
            ];

            return successfulResponse($data);
        }

        return failedResponse([], '', HTTP_STATUS_CODE_UNAUTHORIZED);
    }

    public function register (RegisterPostRequest $request,
                              ?string             $option = null) : Response|Application|ResponseFactory
    {
        if ($option == 'third-party')
        {
            $user = User::create($request->validated());
        }
        else
        {
            $inputs             = $request->validated();
            $inputs['password'] = bcrypt($inputs['password']);

            $user = User::create($inputs);
        }

        $accessToken = $user->createToken('access_token')->plainTextToken;
        $data        = [
            'user'        => $this->userDTO->format($user),
            'accessToken' => $accessToken,
        ];
        return successfulResponse($data);
    }
}
