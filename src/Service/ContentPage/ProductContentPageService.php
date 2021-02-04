<?php

declare(strict_types = 1);

namespace App\Service\ContentPage;

use App\Helper\JwtTokenHelper;
use App\Service\HttpClient\HttpClientService;

class ProductContentPageService implements ProductContentPageInterface
{
    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    /** @var HttpClientService $httpClientService */
    private $httpClientService;

    /** @var string $urlLoadContentPage */
    private $urlUpdateContentPage;

    public function __construct(
        HttpClientService $httpClientService,
        JwtTokenHelper $jwtTokenHelper,
        string $urlUpdateContentPage
    ) {
        $this->httpClientService = $httpClientService;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlUpdateContentPage = $urlUpdateContentPage;
    }

    public function updateContentPage(int $id, string $html, string $style, string $hash): array
    {
        $token = $this->jwtTokenHelper->getToken();

        return $this->httpClientService->sendRequest('PUT', $this->urlUpdateContentPage,[
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
    }
}
