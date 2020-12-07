<?php

declare(strict_types=1);

namespace App\Repository;

interface PageRepositoryInterface
{
    public const PATH_FILE = 'content_%s.json';

    public function savePage(int $id, string $content, string $style): void;
    public function getContentPage(int $id): array;
}
