<?php

declare(strict_types = 1);

namespace App\Service\HttpClient;

use App\Exceptions\ApiConstructorPageException;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ErrorHttpClientService
{
    public function catchResponseHttpClientException(ResponseInterface $response): void
    {
        $contentResponse = $response->toArray(false);

        throw new ApiConstructorPageException(
            $contentResponse['errors']['message'] ?? 'Ошибка выполнения операции на сервере.',
            $contentResponse['errors']['errors'] ?? [],
            $response->getStatusCode()
        );
    }
}
