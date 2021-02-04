<?php

declare(strict_types = 1);

namespace App\Service;

use App\Service\ContentPage\DelayContentPageInterface;
use App\Service\HashContent\HashContentInterface;

class DelayProductDesignPageService
{
    /** @var DelayContentPageInterface $delayContentPage */
    private $delayContentPage;

    /** @var HashContentInterface $hashContent */
    private $hashContent;

    public function __construct(DelayContentPageInterface $delayContentPage, HashContentInterface $hashContent)
    {
        $this->delayContentPage = $delayContentPage;
        $this->hashContent = $hashContent;
    }

    public function saveContentPage(int $id, string $html, string $style, string $publicationTime): array
    {
        $hash = $this->hashContent->getHashContent($id, $html, $style);

        return $this->delayContentPage->saveDelayContentPage($id, $html, $style, $publicationTime, $hash);
    }
}
