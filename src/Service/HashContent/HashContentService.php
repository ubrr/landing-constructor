<?php

declare(strict_types = 1);

namespace App\Service\HashContent;

use App\Helper\JwtTokenHelper;

class HashContentService implements HashContentInterface
{
    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    /** @var string $hashKey */
    private $hashKey;

    public function __construct(JwtTokenHelper $jwtTokenHelper, string $hashKey)
    {
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->hashKey = $hashKey;
    }

    public function getHashContent(int $id, string $html, string $style): string
    {
        $token = $this->jwtTokenHelper->getToken();

        return $this->generateHashContent([$id, $html, $style, $token]);
    }

    private function generateHashContent(array $content)
    {
        $strContent = implode('', $content) . $this->hashKey;

        return md5(sha1($strContent));
    }
}
