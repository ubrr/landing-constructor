<?php

declare(strict_types=1);

namespace App\Helper;

class HashInformationHelper
{
    private $hashKey;

    public function __construct(string $hashKey)
    {
        $this->hashKey = $hashKey;
    }

    public function getHash(array $content): string
    {
        $strContent = implode('', $content) . $this->hashKey;

        return md5(sha1($strContent));
    }
}
