<?php

declare(strict_types=1);

namespace App\Service\AuthManager;

class TokenAuthManager implements AuthManagerInterface
{
    public function canRead(int $id): bool
    {
        // TODO: same logic to getting permission on read
        return true;
    }

    public function canSave(int $id): bool
    {
        // TODO: same logic to getting permission on save
        return true;
    }
}