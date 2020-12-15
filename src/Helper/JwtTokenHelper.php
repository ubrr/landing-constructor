<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\HttpFoundation\RequestStack;

class JwtTokenHelper
{
    /** @var RequestStack $requestStack */
    private $requestStack;

    private const KEY_REQUEST_TOKEN = 'token';
    private const KEY_SESSION_TOKEN = 'token';

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getToken(): string
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