<?php

declare(strict_types = 1);

namespace App\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ApiConstructorPageException extends RuntimeException
{
    public function __construct(string $message = '', $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}
