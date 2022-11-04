<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\DTOs\UserDTO;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Requests\LoginPostRequest;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use function App\Helpers\failedResponse;
use function App\Helpers\successfulResponse;
use const App\Helpers\HTTP_STATUS_CODE_CREATED;
use const App\Helpers\HTTP_STATUS_CODE_UNAUTHORIZED;

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
            if (auth()->attempt($request->validated()))
            {
                $accessToken = auth()->user()->createToken('access_token')->plainTextToken;
                $data        = [
                    'user'        => $this->userDTO->format(auth()->user()),
                    'accessToken' => $accessToken,
                ];

                return successfulResponse($data);
            }
            else
            {
                return failedResponse([], '', HTTP_STATUS_CODE_UNAUTHORIZED);
            }
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
}
