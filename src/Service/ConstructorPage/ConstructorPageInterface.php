<?php

declare(strict_types=1);

namespace App\Service\ConstructorPage;

interface ConstructorPageInterface
{
    public const KEY_CONTENT = 'content';
    public const KEY_STYLE = 'style';

    public function getContentPage(int $id): array;
    public function saveContentPage(int $id, string $content, string $style): array;
}
