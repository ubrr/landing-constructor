<?php

declare(strict_types = 1);

namespace App\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundFileEntryPointsException extends RuntimeException
{
    public function __construct(string $message = '', $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $code);
    }
}
