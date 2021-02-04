<?php

declare(strict_types = 1);

namespace App\Service\HttpClient;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClientService
{
    /** @var ErrorHttpClientService $errorHttpClientService */
    private $errorHttpClientService;

    /** @var HttpClientInterface $client */
    private $client;

    public function __construct(HttpClientInterface $client, ErrorHttpClientService $errorHttpClientService)
    {
        $this->client = $client;
        $this->errorHttpClientService = $errorHttpClientService;
    }

    public function sendRequest(string $method, string $url, array $options = []): array
    {
        $response = $this->client->request($method, $url, $options);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $this->errorHttpClientService->catchResponseHttpClientException($response);
        }

        return $response->toArray(false);
    }
}
