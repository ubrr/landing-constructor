<?php

declare(strict_types = 1);

namespace App\Service\DesignPageReceiver;

class DelayProductDesignReceiver extends AbstractDesignPageReceiver
{
    /** @var DelayProductDesignConnector $delayProductDesignConnector */
    private $delayProductDesignConnector;

    public function __construct(DelayProductDesignConnector $delayProductDesignConnector)
    {
        $this->delayProductDesignConnector = $delayProductDesignConnector;
    }

    public function getConnect() : AbstractDesignPageConnector
    {
        return $this->delayProductDesignConnector;
    }
}
