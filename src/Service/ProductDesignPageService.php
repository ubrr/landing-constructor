<?php

declare(strict_types = 1);

namespace App\Service;

use App\Service\ContentPage\ProductContentPageInterface;
use App\Service\HashContent\HashContentInterface;

class ProductDesignPageService
{
    /** @var ProductContentPageInterface $productContentPage */
    private $productContentPage;

    /** @var HashContentInterface $hashContent */
    private $hashContent;

    public function __construct(ProductContentPageInterface $productContentPage, HashContentInterface $hashContent)
    {
        $this->productContentPage = $productContentPage;
        $this->hashContent = $hashContent;
    }

    public function updateContentPage(int $id, string $html, string $style): array
    {
        $hash = $this->hashContent->getHashContent($id, $html, $style);

        return $this->productContentPage->updateContentPage($id, $html, $style, $hash);
    }
}
