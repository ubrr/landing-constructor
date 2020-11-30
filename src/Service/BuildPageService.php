<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\InvalidActionUserException;
use App\Service\AuthManager\AuthManagerInterface;
use App\Service\ConstructorPage\ConstructorPageInterface;

class BuildPageService
{
    private AuthManagerInterface $authManager;
    private ConstructorPageInterface $constructorPage;

    public function __construct(AuthManagerInterface $authManager, ConstructorPageInterface $constructorPage)
    {
        $this->authManager = $authManager;
        $this->constructorPage = $constructorPage;
    }

    public function fetchContentPage(int $id): array
    {
        if (!$this->authManager->canRead($id)) {
            throw new InvalidActionUserException('Permission denied: The user cant get content page.');
        }

        return $this->constructorPage->getContentPage($id);
    }

    public function saveContentPage(int $id, string $content, string $style): array
    {
        if (!$this->authManager->canSave($id)) {
            throw new InvalidActionUserException('Permission denied: The user cant save content page.');
        }

        return $this->constructorPage->saveContentPage($id, $content, $style);
    }
}
