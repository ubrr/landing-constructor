<?php

declare(strict_types=1);

namespace App\Service\HashInformation;

interface HashInformationInterface
{
    public function checkHashInformation(int $id, string $content, string $style): bool;
}
