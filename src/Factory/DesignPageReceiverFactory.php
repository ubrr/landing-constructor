<?php

declare(strict_types = 1);

namespace App\Factory;

use App\Service\DesignPageReceiver\AbstractDesignPageReceiver;
use App\Service\DesignPageReceiver\DelayProductDesignReceiver;
use App\Service\DesignPageReceiver\ProductDesignReceiver;

class DesignPageReceiverFactory
{
    /** @var DelayProductDesignReceiver $delayProductDesignReceiver */
    private $delayProductDesignReceiver;

    /** @var ProductDesignReceiver $productDesignReceiver */
    private $productDesignReceiver;

    public function __construct(DelayProductDesignReceiver $delayProductDesignReceiver, ProductDesignReceiver $productDesignReceiver)
    {
        $this->delayProductDesignReceiver = $delayProductDesignReceiver;
        $this->productDesignReceiver = $productDesignReceiver;
    }

    public function getDesignPageReceiver(bool $isEditDelayed): AbstractDesignPageReceiver
    {
        if ($isEditDelayed) {
            return $this->delayProductDesignReceiver;
        }

        return  $this->productDesignReceiver;
    }
}
