<?php

declare(strict_types = 1);

namespace App\Service\DesignPageReceiver;

use App\Helper\JwtTokenHelper;
use App\Service\HttpClient\HttpClientService;

abstract class AbstractDesignPageConnector
{
    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    /** @var HttpClientService $httpClientService */
    private $httpClientService;

    /** @var string $urlLoadContentPage */
    protected $urlLoadContentPage;

    public function __construct(HttpClientService $httpClientService, JwtTokenHelper $jwtTokenHelper, string $urlLoadContentPage)
    {
        $this->httpClientService = $httpClientService;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlLoadContentPage = $urlLoadContentPage;
    }

    public function getContent(int $id): array
    {
        $token = $this->jwtTokenHelper->getToken();

        return $this->httpClientService->sendRequest('GET', $this->urlLoadContentPage, [
            'auth_bearer' => $token,
            'query' => [
                'id' => $id,
            ]
        ]);
    }
}
