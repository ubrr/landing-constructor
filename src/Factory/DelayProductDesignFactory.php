<?php

declare(strict_types = 1);

namespace App\Factory;

use App\Service\ContentPage\DelayContentPageService;
use App\Service\HashContent\HashContentService;
use App\Service\DelayProductDesignPageService;

class DelayProductDesignFactory
{
    /** @var DelayContentPageService $delayContentPageService */
    private $delayContentPageService;

    /** @var HashContentService $hashContentService */
    private $hashContentService;

    public function __construct(
        DelayContentPageService $delayContentPageService,
        HashContentService $hashContentService
    ) {
        $this->delayContentPageService = $delayContentPageService;
        $this->hashContentService = $hashContentService;
    }

    public function getDelayProductDesign(): DelayProductDesignPageService
    {
        return new DelayProductDesignPageService($this->delayContentPageService, $this->hashContentService);
    }
}
