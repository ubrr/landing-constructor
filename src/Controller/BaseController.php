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

    protected function internalServerErrorResponse($payload): JsonResponse
    {
        return $this->json($payload, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function resourceForbiddenResponse($payload): JsonResponse
    {
        return $this->json($payload, JsonResponse::HTTP_FORBIDDEN);
    }
}
