<?php

declare(strict_types = 1);

namespace App\Service\ContentPage;

interface DelayContentPageInterface
{
    public function saveDelayContentPage(
        int $id,
        string $html,
        string $style,
        string $publicationTime,
        string $hash
    ): array;
}
