<?php

declare(strict_types = 1);

namespace App\Factory;

use App\Service\ConstructorPage\ApiConstructorPageService;
use App\Service\BuildPageService;
use App\Service\HashContent\HashContentService;

class BuildPageFactory
{
    /** @var ApiConstructorPageService $apiConstructorPage */
    private $apiConstructorPage;

    /** @var HashContentService $hashContentService */
    private $hashContentService;

    public function __construct(
        ApiConstructorPageService $apiConstructorPage,
        HashContentService $hashContentService
    ) {
        $this->apiConstructorPage = $apiConstructorPage;
        $this->hashContentService = $hashContentService;
    }

    public function getBuildPage(): BuildPageService
    {
        return new BuildPageService($this->apiConstructorPage, $this->hashContentService);
    }
}
