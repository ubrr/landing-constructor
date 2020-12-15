<?php

declare(strict_types=1);

namespace App\Service\Permission;

use App\Exceptions\AccessDeniedException;
use App\Helper\JwtTokenHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class ApiPermissionService implements PermissionServiceInterface
{
    /** @var HttpClientInterface $client */
    private $client;

    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    /** @var string $urlCheckPermissionRead */
    private $urlCheckPermissionRead;

    /** @var string $urlCheckPermissionUpdate */
    private $urlCheckPermissionUpdate;

    public function __construct(
        HttpClientInterface $client,
        JwtTokenHelper $jwtTokenHelper,
        string $urlCheckPermissionRead,
        string $urlCheckPermissionUpdate
    ) {
        $this->client = $client;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlCheckPermissionRead = $urlCheckPermissionRead;
        $this->urlCheckPermissionUpdate = $urlCheckPermissionUpdate;
    }

    public function canRead(int $id): bool
    {
        if ($this->checkPermission($this->urlCheckPermissionRead)) {
            return true;
        }

        return false;
    }

    public function canUpdate(int $id): bool
    {
        if ($this->checkPermission($this->urlCheckPermissionUpdate)) {
            return true;
        }

        return false;
    }

    private function checkPermission(string $url): bool
    {
        $token = $this->jwtTokenHelper->getToken();

        try {
            $response = $this->client->request('GET', $url, ['auth_bearer' => $token]);
            $content = $response->toArray();

            if ($content['status']) {
                return true;
            };

        } catch (ExceptionInterface $e) {
            if ($response->getStatusCode() !== Response::HTTP_FORBIDDEN) {
                throw new AccessDeniedException($e->getMessage());
            }
        }

        return false;
    }
}
