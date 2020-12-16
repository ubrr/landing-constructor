<?php

declare(strict_types=1);

namespace App\Service\AuthManager;

use App\Exceptions\InvalidCredentialsException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use App\Helper\JwtTokenHelper;

class JwtTokenAuthenticator implements AuthenticationInterface
{
    /** @var HttpClientInterface $client */
    private $client;

    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    /** @var string $urlJwtAuthentication */
    private $urlJwtAuthentication;

    public function __construct(
        HttpClientInterface $client,
        JwtTokenHelper $jwtTokenHelper,
        string $urlJwtAuthentication
    ) {
        $this->client = $client;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlJwtAuthentication = $urlJwtAuthentication;
    }

    public function checkCredentials(): bool
    {
        $token = $this->jwtTokenHelper->getToken();

        if (!$token) {
            throw new InvalidCredentialsException('Jwt token does not exist!');
        }

        try {
            $response = $this->client->request('GET', $this->urlJwtAuthentication, [
                'auth_bearer' => $token
            ]);

            $content = $response->toArray();

            if ($content['status']) {
                return true;
            }

        } catch (ExceptionInterface $e) {
            if ($response->getStatusCode() !== Response::HTTP_UNAUTHORIZED) {
                throw new InvalidCredentialsException($e->getMessage());
            }
        }

        return false;
    }
}
