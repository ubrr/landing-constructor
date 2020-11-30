<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\PageNotFoundException;

class BuildPageService
{
    private HttpClientService $httpClientService;
    private string $hostLoadContentPage;
    private string $hostSaveContentPage;

    private const KEY_CONTENT = 'content';
    private const KEY_STYLE = 'style';

    public function __construct(
        HttpClientService $httpClientService,
        string $hostLoadContentPage,
        string $hostSaveContentPage
    ) {
        $this->httpClientService = $httpClientService;
        $this->hostLoadContentPage = $hostLoadContentPage;
        $this->hostSaveContentPage = $hostSaveContentPage;
    }

    public function fetchContentPage(int $id): array
    {
        $content = $this->httpClientService->sendGet($this->hostLoadContentPage, ['query' => ['id' => $id]]);
        $content = json_decode($content,true);

        if (!array_key_exists (self::KEY_CONTENT, $content)
            || !array_key_exists (self::KEY_STYLE, $content)
        ) {
            throw new PageNotFoundException('Content page not found');
        }

        return $content;
    }

    public function saveContentPage(int $id, string $content, string $style): string
    {
        $content = $this->httpClientService->sendPost(
            $this->hostSaveContentPage,
            [
                'body' => [
                    'id' => $id,
                    'content' => $content,
                    'style' => $style
                ]
            ]
        );

        return $content;
    }
}
