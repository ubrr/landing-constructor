<?php

declare(strict_types=1);

namespace App\Service\Permission;

interface PermissionServiceInterface
{
    public function canRead(int $id): bool;
    public function canSave(int $id): bool;
}
