<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\InvalidActionUserException;
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

    public function __construct(
        PermissionServiceInterface $permissionService,
        ConstructorPageInterface $constructorPage,
        AuthenticationInterface $authentication
    ) {
        $this->permissionService = $permissionService;
        $this->constructorPage = $constructorPage;
        $this->authentication = $authentication;
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

        if (!$this->permissionService->canUpdate($id)) {
            throw new InvalidActionUserException('Permission denied: The user can not save content page.');
        }

        return $this->constructorPage->updateContentPage($id, $content, $style);
    }
}
