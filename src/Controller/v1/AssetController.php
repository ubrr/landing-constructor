<?php

declare(strict_types = 1);

namespace App\Controller\v1;

use App\Controller\BaseController;
use App\Exceptions\NotFoundFileEntryPointsException;
use App\Service\AssetService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class AssetController extends BaseController
{
    /**
     * @Route("/getAssets/{slug}", methods={"GET"})
     */
    public function getAssets(string $slug, AssetService $assetService): JsonResponse
    {
        try {
            $assets = $assetService->getAssetsBySlug($slug);
            return $this->successResponse($assets);
        } catch (NotFoundFileEntryPointsException $e) {
            return $this->responseException($e->getMessage(), $e->getCode());
        } catch (Throwable $e) {
            return $this->responseException($e->getMessage());
        }
    }
}
