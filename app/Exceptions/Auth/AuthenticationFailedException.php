<?php

namespace App\Exceptions\Auth;

use Flugg\Responder\Exceptions\Http\HttpException;

class AuthenticationFailedException extends HttpException
{
    protected $errorCode = 'auth_failed';

    protected $status = 422;
}
