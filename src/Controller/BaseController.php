<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    protected function successResponse($payload): JsonResponse
    {
        return $this->json($payload, JsonResponse::HTTP_OK);
    }

    protected function responseException(
        string $message,
        int $code = JsonResponse::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        return $this->json(['message' => $message], $code);
    }

    protected function responseApiException(
        string $message,
        array $errors,
        int $code = JsonResponse::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        return $this->json(['message' => $message, 'errors' => $errors], $code);
    }
}
