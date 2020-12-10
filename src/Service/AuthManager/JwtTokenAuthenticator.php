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
    private HttpClientInterface $client;
    private JwtTokenHelper $jwtTokenHelper;

    private string $urlJwtAuthentication;

    public function __construct(HttpClientInterface $client, JwtTokenHelper $jwtTokenHelper, $urlJwtAuthentication)
    {
        $this->client = $client;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlJwtAuthentication = $urlJwtAuthentication;
    }

    public function checkCredentials(): bool
    {
        $token =  $this->jwtTokenHelper->getToken();

        if (!$token) {
            throw new InvalidCredentialsException('Jwt token does not exist!');
        }

        try {
            $response = $this->client->request('GET', $this->urlJwtAuthentication, [
                'auth_bearer' => $token
            ]);

            $content = json_decode($response->getContent(), true);

            if ($response->getStatusCode() === Response::HTTP_OK && $content['data']) {
                return true;
            }

        } catch (ExceptionInterface $e) {
            throw new InvalidCredentialsException($e->getMessage());
        }

        return false;
    }
}
