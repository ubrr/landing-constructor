<?php

declare(strict_types=1);

namespace App\Factory;

use App\Service\AuthManager\JwtTokenAuthenticator;
use App\Service\ConstructorPage\ApiConstructorPage;
use App\Service\Permission\ApiPermissionService;
use App\Service\BuildPageService;

class BuildPageFactory
{
    /** @var ApiPermissionService $apiPermissionService */
    private $apiPermissionService;

    /** @var ApiConstructorPage $apiConstructorPage */
    private $apiConstructorPage;

    /** @var JwtTokenAuthenticator $jwtTokenAuthenticator */
    private $jwtTokenAuthenticator;

    public function __construct(
        ApiPermissionService $apiPermissionService,
        ApiConstructorPage $apiConstructorPage,
        JwtTokenAuthenticator $jwtTokenAuthenticator
    ) {
        $this->apiPermissionService = $apiPermissionService;
        $this->apiConstructorPage = $apiConstructorPage;
        $this->jwtTokenAuthenticator = $jwtTokenAuthenticator;
    }

    public function getBuildPage(): BuildPageService
    {
        return new BuildPageService(
            $this->apiPermissionService,
            $this->apiConstructorPage,
            $this->jwtTokenAuthenticator
        );
    }
}