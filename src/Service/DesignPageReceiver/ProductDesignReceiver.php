<?php

declare(strict_types = 1);

namespace App\Service\DesignPageReceiver;

class ProductDesignReceiver extends AbstractDesignPageReceiver
{
    /** @var ProductDesignConnector $productDesignConnector */
    private $productDesignConnector;

    public function __construct(ProductDesignConnector $productDesignConnector)
    {
        $this->productDesignConnector = $productDesignConnector;
    }

    public function getConnect(): AbstractDesignPageConnector
    {
        return $this->productDesignConnector;
    }
}
