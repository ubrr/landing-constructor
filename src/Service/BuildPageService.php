<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\InvalidActionUserException;
use App\Exceptions\AccessDeniedException;
use App\Service\HashInformation\HashInformationInterface;
use App\Service\Permission\PermissionServiceInterface;
use App\Service\ConstructorPage\ConstructorPageInterface;
use App\Service\AuthManager\AuthenticationInterface;
use App\Exceptions\InvalidCredentialsException;

class BuildPageService
{
    /** @var PermissionServiceInterface $permissionService */
    private $permissionService;

    /** @var ConstructorPageInterface $constructorPage */
    private $constructorPage;

    /** @var AuthenticationInterface $authentication */
    private $authentication;

    /** @var HashInformationInterface $hashInformation */
    private $hashInformation;

    public function __construct(
        PermissionServiceInterface $permissionService,
        ConstructorPageInterface $constructorPage,
        AuthenticationInterface $authentication,
        HashInformationInterface $hashInformation
    ) {
        $this->permissionService = $permissionService;
        $this->constructorPage = $constructorPage;
        $this->authentication = $authentication;
        $this->hashInformation = $hashInformation;
    }

    public function fetchContentPage(int $id): array
    {
        if (!$this->authentication->checkCredentials()) {
            throw new InvalidCredentialsException('Invalid credentials.');
        }

        if (!$this->permissionService->canRead($id)) {
            throw new InvalidActionUserException('Permission denied: The user can not get content page.');
        }

        return $this->constructorPage->getContentPage($id);
    }

    public function updateContentPage(int $id, string $content, string $style): array
    {
        if (!$this->authentication->checkCredentials()) {
            throw new InvalidCredentialsException('Invalid credentials.');
        }

        if (!$this->hashInformation->checkHashInformation($id, $content, $style)) {
            throw new AccessDeniedException('Permission denied: Invalid user.');
        }

        if (!$this->permissionService->canUpdate($id)) {
            throw new InvalidActionUserException('Permission denied: The user can not update content page.');
        }

        return $this->constructorPage->updateContentPage($id, $content, $style);
    }
}
