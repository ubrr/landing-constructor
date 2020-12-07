<?php

declare(strict_types=1);

namespace App\Service\AuthManager;

use App\Exceptions\InvalidCredentialsException;
use Symfony\Component\HttpFoundation\RequestStack;

class JwtTokenAuthenticator implements AuthenticationInterface
{
    private RequestStack $requestStack;

    private const KEY_REQUEST_TOKEN = 'token';
    private const KEY_SESSION_TOKEN = 'token';

    private string $urlJwtAuthentication;

    public function __construct(RequestStack $requestStack, $urlJwtAuthentication)
    {
        $this->requestStack = $requestStack;
        $this->urlJwtAuthentication = $urlJwtAuthentication;
    }

    public function checkCredentials(): bool
    {
        $token = $this->getToken();

        if (!$token) {
            throw new InvalidCredentialsException('Jwt token does not exist!');
        }

        // TODO: some logic validate token

        return true;
    }

    private function getToken(): string
    {
        $token = '';
        $request = $this->requestStack->getCurrentRequest();

        if ($request->get(self::KEY_REQUEST_TOKEN)) {
            $token = trim($request->get(self::KEY_REQUEST_TOKEN));
        }

        if (!$token && $request->getSession()->has(self::KEY_SESSION_TOKEN)) {
            $token = $request->getSession()->get(self::KEY_SESSION_TOKEN);
        } else {
            $this->setTokenToSession($token);
        }

        return $token;
    }

    private function setTokenToSession(string $token): void
    {
        $this->requestStack->getCurrentRequest()->getSession()->set(self::KEY_SESSION_TOKEN, $token);
    }
}
