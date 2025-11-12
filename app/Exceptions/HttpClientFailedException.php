<?php

namespace App\Exceptions;

use Flugg\Responder\Exceptions\Http\HttpException;

class HttpClientFailedException extends HttpException
{
    protected $statusCode = 400;
}
