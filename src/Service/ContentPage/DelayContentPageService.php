<?php

declare(strict_types = 1);

namespace App\Service\ContentPage;

use App\Helper\JwtTokenHelper;
use App\Service\HttpClient\HttpClientService;

class DelayContentPageService implements DelayContentPageInterface
{
    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    /** @var HttpClientService $httpClientService */
    private $httpClientService;

    /** @var string $urlSaveContentPage */
    private $urlSaveDelayContentPage;

    public function __construct(
        HttpClientService $httpClientService,
        JwtTokenHelper $jwtTokenHelper,
        string $urlSaveDelayContentPage
    ) {
        $this->httpClientService = $httpClientService;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlSaveDelayContentPage = $urlSaveDelayContentPage;
    }

    public function saveDelayContentPage(
        int $id,
        string $html,
        string $style,
        string $publicationTime,
        string $hash
    ): array
    {
        $token = $this->jwtTokenHelper->getToken();

        return $this->httpClientService->sendRequest('POST', $this->urlSaveDelayContentPage,[
            'auth_bearer' => $token,
            'query' => [
                'id' => $id,
            ],
            'body' => [
                'html' => $html,
                'style' => $style,
                'publicationTime' => $publicationTime,
                'hash' => $hash
            ]
        ]);
    }
}
