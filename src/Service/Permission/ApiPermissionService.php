<?php

declare(strict_types=1);

namespace App\Service\Permission;

use App\Exceptions\AccessDeniedException;
use App\Helper\JwtTokenHelper;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class ApiPermissionService implements PermissionServiceInterface
{
    private HttpClientInterface $client;
    private JwtTokenHelper $jwtTokenHelper;

    private string $urlCheckPermissionRead;
    private string $urlCheckPermissionUpdate;

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

        return true;
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
            throw new AccessDeniedException($e->getMessage());
        }

        return false;
    }
}
