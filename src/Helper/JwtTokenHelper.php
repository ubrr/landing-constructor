<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class JwtTokenHelper
{
    /** @var RequestStack $requestStack */
    private $requestStack;

    /** @var SessionInterface $session */
    private $session;

    private const KEY_REQUEST_TOKEN = 'token';
    private const KEY_SESSION_TOKEN = 'token';

    public function __construct(RequestStack $requestStack, SessionInterface $session)
    {
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

    public function getToken(): string
    {
        $token = '';
        $request = $this->requestStack->getCurrentRequest();

        if ($request->get(self::KEY_REQUEST_TOKEN)) {
            $token = trim($request->get(self::KEY_REQUEST_TOKEN));
        }

        if (!$token && $this->session->has(self::KEY_SESSION_TOKEN)) {
            $token =  $this->session->get(self::KEY_SESSION_TOKEN);
        } else {
            $this->setTokenToSession($token);
        }

        return $token;
    }

    private function setTokenToSession(string $token): void
    {
        $this->session->set(self::KEY_SESSION_TOKEN, $token);
    }
}