<?php

declare(strict_types = 1);

namespace App\Service\ContentPage;

interface ProductContentPageInterface
{
    public function updateContentPage(int $id, string $html, string $style, string $hash): array;
}
