<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function App\Helpers\failedResponse;
use const App\Helpers\HTTP_STATUS_CODE_NOT_FOUND;
use const App\Helpers\HTTP_STATUS_CODE_BAD_REQUEST;
use const App\Helpers\HTTP_STATUS_CODE_UNAUTHORIZED;
use const App\Helpers\HTTP_STATUS_CODE_UNAUTHENTICATED;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * @return void
     */
    public function register ()
    {
        $this->renderable(function (ValidationException $exception)
        {
            return failedResponse($exception->validator->errors()->messages(),
                                  $exception->getMessage(), HTTP_STATUS_CODE_BAD_REQUEST);
        });

        $this->renderable(function (AuthenticationException $exception)
        {
            return failedResponse([], $exception->getMessage(), HTTP_STATUS_CODE_UNAUTHENTICATED);
        });

        $this->renderable(function (AuthorizationException $exception)
        {
            return failedResponse([], $exception->getMessage(), HTTP_STATUS_CODE_UNAUTHORIZED);
        });

        $this->renderable(function (NotFoundHttpException $exception)
        {
            return failedResponse([], 'Not found http', HTTP_STATUS_CODE_NOT_FOUND);
        });

        $this->renderable(function (Throwable $exception)
        {
            if (config('app.debug'))
            {
                return failedResponse([], $exception->getMessage());
            }

            return failedResponse();
        });

        $this->reportable(function (Throwable $e)
        {
            //
        });
    }
}
