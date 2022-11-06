<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\LogoutPostRequest;
use App\Http\Requests\Auth\RegisterPostRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use function App\Helpers\failedResponse;
use function App\Helpers\successfulResponse;
use const App\Helpers\ROLES;
use const App\Helpers\HTTP_STATUS_CODE_CREATED;
use const App\Helpers\HTTP_STATUS_CODE_UNAUTHENTICATED;

class AuthController extends Controller
{
    private UserDTO $userDTO;

    /**
     * @param UserDTO $userDTO
     */
    public function __construct (UserDTO $userDTO) { $this->userDTO = $userDTO; }

    public function login (LoginPostRequest $request,
                           ?string          $thirdParty = null) : Response|Application|ResponseFactory
    {
        if ($thirdParty == null)
        {
            if (auth()->attempt(array_merge($request->validated(),
                                            ['role' => Arr::only(ROLES,
                                                                 ['normal_user', 'premium_user'])])))
            {
                $accessToken = auth()->user()->createToken('access_token')->plainTextToken;
                $data        = [
                    'user'        => $this->userDTO->format(auth()->user()),
                    'accessToken' => $accessToken,
                ];

                return successfulResponse($data);
            }

            return failedResponse([], '', HTTP_STATUS_CODE_UNAUTHENTICATED);
        }

        $thirdPartyUser = Socialite::driver($thirdParty)->userFromToken($request->token);
        $user           = User::where('github_email', $thirdPartyUser->email)
                              ->orWhere('facebook_email', $thirdPartyUser->email)
                              ->orWhere('google_email', $thirdPartyUser->email)->first();

        if ($user == null)
        {
            $nickname = explode('@', $thirdPartyUser->email)[0] . '-' . Str::random(10);
            $user     = User::create(['nickname'            => $nickname,
                                      "{$thirdParty}_email" => $thirdPartyUser->email]);
        }

        $accessToken = $user->createToken('access_token')->plainTextToken;
        $data        = [
            'user'        => $this->userDTO->format($user),
            'accessToken' => $accessToken,
        ];

        return successfulResponse($data);
    }

    public function register (RegisterPostRequest $request) : Response|Application|ResponseFactory
    {
        $inputs             = $request->validated();
        $inputs['password'] = bcrypt($inputs['password']);
        $user               = User::create($inputs);

        $accessToken = $user->createToken('access_token')->plainTextToken;
        $data        = [
            'user'        => $this->userDTO->format($user),
            'accessToken' => $accessToken,
        ];

        return successfulResponse($data, '', HTTP_STATUS_CODE_CREATED);
    }

    public function logout (LogoutPostRequest $request) : Response|Application|ResponseFactory
    {
        $user = auth()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return successfulResponse();
    }

    public function logoutAll (LogoutPostRequest $request) : Response|Application|ResponseFactory
    {
        auth()->user()->tokens()->delete();
        return successfulResponse();
    }
}
