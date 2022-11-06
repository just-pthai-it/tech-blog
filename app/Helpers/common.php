<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

const RESPONSE_STATUS_SUCCESSFUL = 1;
const RESPONSE_STATUS_FAILED     = 0;

const HTTP_STATUS_CODE_OK              = 200;
const HTTP_STATUS_CODE_CREATED         = 201;
const HTTP_STATUS_CODE_BAD_REQUEST     = 400;
const HTTP_STATUS_CODE_UNAUTHENTICATED = 401;
const HTTP_STATUS_CODE_UNAUTHORIZED    = 403;
const HTTP_STATUS_CODE_NOT_FOUND       = 404;
const HTTP_STATUS_CODE_UNPROCESSABLE   = 422;
const HTTP_STATUS_CODE_SYSTEM_ERROR    = 500;

function successfulResponse (array $data = [], string $message = '',
                             int   $httpStatusCode = HTTP_STATUS_CODE_OK,
                             array $additional = []) : Response|Application|ResponseFactory
{
    $response = array_merge(
        [
            'status'  => RESPONSE_STATUS_SUCCESSFUL,
            'code'    => $httpStatusCode,
            'message' => empty($message) ? 'Successful' : $message,
            'data'    => $data,
        ],
        $additional
    );

    return response($response, HTTP_STATUS_CODE_OK);
}

function failedResponse (array $errors = [], string $message = '',
                         int   $httpStatusCode = HTTP_STATUS_CODE_UNPROCESSABLE,
                         array $additional = []) : Response|Application|ResponseFactory
{
    $response = array_merge(
        [
            'status'  => RESPONSE_STATUS_FAILED,
            'code'    => $httpStatusCode,
            'message' => empty($message) ? 'Failed' : $message,
            'errors'  => $errors,
        ],
        $additional
    );

    return response($response, HTTP_STATUS_CODE_UNPROCESSABLE);
}
