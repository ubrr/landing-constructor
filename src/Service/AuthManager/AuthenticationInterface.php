<?php

declare(strict_types=1);

namespace App\Service\AuthManager;

interface AuthenticationInterface
{
    public function checkCredentials(): bool;
}
