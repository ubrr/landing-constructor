<?php

declare(strict_types = 1);

namespace App\Service\DesignPageReceiver;

abstract class AbstractDesignPageReceiver
{
    abstract public function getConnect(): AbstractDesignPageConnector;

    public function getContentPage(int $id): array
    {
        $connect = $this->getConnect();

        return $connect->getContent($id);
    }
}
