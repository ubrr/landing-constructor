<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Controller\BaseController;
use App\Exceptions\AccessDeniedException;
use App\Exceptions\InvalidActionUserException;
use App\Factory\BuildPageFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class BuildPageController extends BaseController
{
    /** @var BuildPageFactory $buildPageFactory */
    private $buildPageFactory;

    public function __construct(BuildPageFactory $buildPageFactory)
    {
        $this->buildPageFactory = $buildPageFactory;
    }

    /**
     * @Route("/build/{id}", name="app_page_build", methods={"GET"})
     */
    public function build(int $id): Response
    {
        $buildPageService = $this->buildPageFactory->getBuildPage();

        try {
            $content = $buildPageService->fetchContentPage((int) $id);
        } catch (Exception $e) {
            return $this->render('error.html.twig', [
                'error' => $e->getMessage()
            ]);
        }

        return $this->render('buildPage/build.html.twig', [
            'id' => $id,
            'content' => $content['content'] ? html_entity_decode($content['content']) : $content['content'],
            'style' => $content['style'] ? html_entity_decode($content['style']) : $content['style']
        ]);
    }

    /**
     * @Route("/update/{id}", name="app_page_update", methods={"POST"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $buildPageService = $this->buildPageFactory->getBuildPage();

        try {
            $content = $buildPageService->updateContentPage(
                (int) $id,
                $request->get('content'),
                $request->get('style')
            );
        } catch (AccessDeniedException | InvalidActionUserException $e) {
            return $this->resourceForbiddenResponse(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            return $this->internalServerErrorResponse(['error' => $e->getMessage()]);
        }

        return $this->successResponse(['content' => $content]);
    }
}
