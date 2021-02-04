<?php

declare(strict_types = 1);

namespace App\Service\DesignPageReceiver;

class DelayProductDesignConnector extends AbstractDesignPageConnector
{
    public function getContent(int $id): array
    {
        return parent::getContent($id);
    }
}
