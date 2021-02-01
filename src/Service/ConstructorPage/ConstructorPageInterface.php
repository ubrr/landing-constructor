<?php

declare(strict_types = 1);

namespace App\Service\ConstructorPage;

interface ConstructorPageInterface
{
    public function getContentPage(int $id): array;
    public function updateContentPage(int $id, string $html, string $style, string $hash): array;
}
