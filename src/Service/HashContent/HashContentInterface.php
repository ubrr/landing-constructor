<?php

declare(strict_types = 1);

namespace App\Service\HashContent;

interface HashContentInterface
{
    public function getHashContent(int $id, string $html, string $style): string;
}
