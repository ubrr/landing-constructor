<?php

declare(strict_types = 1);

namespace App\Service\ConstructorPage;

use Symfony\Contracts\HttpClient\ResponseInterface;
use App\Exceptions\ApiConstructorPageException;

abstract class AbstractApiConstructorPageService
{
    protected function catchResponseHttpClientException(ResponseInterface $response): void
    {
        $contentResponse = $response->toArray(false);
        $messageError = $contentResponse['errors']['message'] ?? '';

        throw new ApiConstructorPageException(
            $messageError ?: 'Ошибка выполнения операции на сервере.',
            $response->getStatusCode()
        );
    }
}
