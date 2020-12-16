<?php

declare(strict_types=1);

namespace App\Factory;

use App\Service\AuthManager\JwtTokenAuthenticator;
use App\Service\ConstructorPage\ApiConstructorPage;
use App\Service\Permission\ApiPermissionService;
use App\Service\BuildPageService;
use App\Service\HashInformation\HashInformationService;

class BuildPageFactory
{
    /** @var ApiPermissionService $apiPermissionService */
    private $apiPermissionService;

    /** @var ApiConstructorPage $apiConstructorPage */
    private $apiConstructorPage;

    /** @var JwtTokenAuthenticator $jwtTokenAuthenticator */
    private $jwtTokenAuthenticator;

    /** @var HashInformationService $hashInformationService */
    private $hashInformationService;

    public function __construct(
        ApiPermissionService $apiPermissionService,
        ApiConstructorPage $apiConstructorPage,
        JwtTokenAuthenticator $jwtTokenAuthenticator,
        HashInformationService $hashInformationService
    ) {
        $this->apiPermissionService = $apiPermissionService;
        $this->apiConstructorPage = $apiConstructorPage;
        $this->jwtTokenAuthenticator = $jwtTokenAuthenticator;
        $this->hashInformationService = $hashInformationService;
    }

    public function getBuildPage(): BuildPageService
    {
        return new BuildPageService(
            $this->apiPermissionService,
            $this->apiConstructorPage,
            $this->jwtTokenAuthenticator,
            $this->hashInformationService
        );
    }
}
