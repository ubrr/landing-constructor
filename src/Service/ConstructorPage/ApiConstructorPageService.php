<?php

declare(strict_types = 1);

namespace App\Service\ConstructorPage;

use App\Helper\JwtTokenHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiConstructorPageService extends AbstractApiConstructorPageService implements ConstructorPageInterface
{
    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    /** @var HttpClientInterface $client */
    private $client;

    /** @var string $urlLoadContentPage */
    private $urlLoadContentPage;

    /** @var string $urlUpdateContentPage */
    private $urlUpdateContentPage;

    public function __construct(
        HttpClientInterface $client,
        JwtTokenHelper $jwtTokenHelper,
        string $urlLoadContentPage,
        string $urlUpdateContentPage
    ) {
        $this->client = $client;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlLoadContentPage = $urlLoadContentPage;
        $this->urlUpdateContentPage = $urlUpdateContentPage;
    }

    public function getContentPage(int $id): array
    {
        $token = $this->jwtTokenHelper->getToken();

        $response = $this->client->request('GET', $this->urlLoadContentPage, [
            'auth_bearer' => $token,
            'query' => [
                'id' => $id,
            ]
        ]);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $this->catchResponseHttpClientException($response);
        }

        return $response->toArray(false);
    }

    public function updateContentPage(int $id, string $html, string $style, string $hash): array
    {
        $token = $this->jwtTokenHelper->getToken();
        $response = $this->client->request('PUT', $this->urlUpdateContentPage, [
            'auth_bearer' => $token,
            'headers'  => [
                'Content-type: application/json',
            ],
            'query' => [
                'id' => $id,
            ],
            'body' => [
                'html' => $html,
                'style' => $style,
                'hash' => $hash
            ]
        ]);

        if ($response->getStatusCode() !== Response::HTTP_OK) {
           $this->catchResponseHttpClientException($response);
        }

        return $response->toArray(false);
    }


}
