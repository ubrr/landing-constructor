<?php

declare(strict_types = 1);

namespace App\Service;

use App\Service\ConstructorPage\ConstructorPageInterface;
use App\Service\HashContent\HashContentInterface;

class BuildPageService
{
    /** @var ConstructorPageInterface $constructorPage */
    private $constructorPage;

    /** @var HashContentInterface $hashContent */
    private $hashContent;

    public function __construct(ConstructorPageInterface $constructorPage, HashContentInterface $hashContent)
    {
        $this->constructorPage = $constructorPage;
        $this->hashContent = $hashContent;
    }

    public function fetchContentPage(int $id): array
    {
        return $this->constructorPage->getContentPage($id);
    }

    public function updateContentPage(int $id, string $html, string $style): array
    {
        $hash = $this->hashContent->getHashContent($id, $html, $style);

        return $this->constructorPage->updateContentPage($id, $html, $style, $hash);
    }
}
