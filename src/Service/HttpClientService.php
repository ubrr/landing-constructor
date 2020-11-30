<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClientService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendGet(string $host, array $options = []): string
    {
        $response = $this->client->request('GET', $host, $options);

        return $response->getContent();
    }

    public function sendPost(string $host, array $options = []): string
    {
        $response = $this->client->request('POST', $host, $options);

        return $response->getContent();
    }
}