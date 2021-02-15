<?php

declare(strict_types = 1);

namespace App\Factory;

use App\Service\ContentPage\ProductContentPageService;
use App\Service\ProductDesignPageService;
use App\Service\HashContent\HashContentService;

class ProductDesignPageFactory
{
    /** @var ProductContentPageService $productDesignPageService */
    private $productContentPageService;

    /** @var HashContentService $hashContentService */
    private $hashContentService;

    public function __construct(
        ProductContentPageService $productContentPageService,
        HashContentService $hashContentService
    ) {
        $this->productContentPageService = $productContentPageService;
        $this->hashContentService = $hashContentService;
    }

    public function getProductDesign(): ProductDesignPageService
    {
        return new ProductDesignPageService($this->productContentPageService, $this->hashContentService);
    }
}
