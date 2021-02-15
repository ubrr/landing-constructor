<?php

declare(strict_types = 1);

namespace App\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ApiConstructorPageException extends RuntimeException
{
    /** @var array $errors */
    private $errors;

    public function __construct(string $message = '', array $errors = [], $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $this->errors= $errors;

        parent::__construct($message, $code);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
