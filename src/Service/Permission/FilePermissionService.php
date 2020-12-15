<?php

declare(strict_types=1);

namespace App\Service\Permission;

class FilePermissionService implements PermissionServiceInterface
{
    public function canRead(int $id): bool
    {
        // TODO: some logic to getting permission on read
        return true;
    }

    public function canUpdate(int $id): bool
    {
        // TODO: some logic to getting permission on save
        return true;
    }
}
