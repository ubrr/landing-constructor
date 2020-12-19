<?php

declare(strict_types=1);

namespace App\Service\HashInformation;

use App\Helper\HashInformationHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Helper\JwtTokenHelper;

class HashInformationService implements HashInformationInterface
{
    /** @var HashInformationHelper $hashInformationHelper */
    private $hashInformationHelper;

    /** @var HttpClientInterface $client */
    private $client;

    /** @var string $urlCheckHashInformation */
    private $urlCheckHashInformation;

    /** @var JwtTokenHelper $jwtTokenHelper */
    private $jwtTokenHelper;

    public function __construct(
        HashInformationHelper $hashInformationHelper,
        HttpClientInterface $client,
        JwtTokenHelper $jwtTokenHelper,
        string $urlCheckHashInformation
    ) {
        $this->hashInformationHelper = $hashInformationHelper;
        $this->client = $client;
        $this->jwtTokenHelper = $jwtTokenHelper;
        $this->urlCheckHashInformation = $urlCheckHashInformation;
    }

    public function checkHashInformation(int $id, string $content, string $style): bool
    {
        $token = $this->jwtTokenHelper->getToken();
        $hashContent = $this->hashInformationHelper->getHash([$id, $content, $style, $token]);

        $request = $this->client->request('POST', $this->urlCheckHashInformation, [
            'auth_bearer' => $token,
            'query' => [
                'id' => $id,
            ],
            'body' => [
                'content' => $content,
                'style' => $style,
                'hash' => $hashContent
            ]
        ]);

        if ($request->getStatusCode() !== Response::HTTP_OK) {
            return false;
        }

        return true;
    }
}
