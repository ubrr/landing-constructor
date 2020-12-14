<?php

declare(strict_types=1);

namespace App\Service\ConstructorPage;

use App\Exceptions\ApiContentPageException;
use App\Exceptions\PageNotFoundException;
use App\Helper\JwtTokenHelper;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class ApiConstructorPage implements ConstructorPageInterface
{
    private JwtTokenHelper $jwtTokenHelper;
    private HttpClientInterface $client;

    private string $urlLoadContentPage;
    private string $urlUpdateContentPage;

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

        try {
            $response = $this->client->request('GET', $this->urlLoadContentPage, [
                'auth_bearer' => $token,
                'query' => [
                    'id' => $id,
                ]
            ]);

            $content = $response->toArray();

            if (empty($content['data'])) {
                throw new PageNotFoundException('Error in getting content page.');
            }

        } catch (ExceptionInterface $e) {
            throw new ApiContentPageException($e->getMessage());
        }

        return $content['data'];
    }

    public function updateContentPage(int $id, string $content, string $style): array
    {
        $token = $this->jwtTokenHelper->getToken();

        try {
            $response = $this->client->request('PUT', $this->urlUpdateContentPage, [
                'auth_bearer' => $token,
                'headers'  => [
                    'Content-type: application/json',
                ],
                'query' => [
                    'id' => $id,
                ],
                'json' => [
                    'content' => $content,
                    'style' => $style,
                ]
            ]);

            $content = $response->toArray();

        } catch (ExceptionInterface $e) {
            throw new ApiContentPageException($e->getMessage());
        }

        return $content;
    }
}
