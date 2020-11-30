<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Controller\BaseController;
use App\Service\BuildPageService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class BuildPageController extends BaseController
{
    private BuildPageService $buildPageService;

    public function __construct(BuildPageService $buildPageService)
    {
        $this->buildPageService = $buildPageService;
    }

    /**
     * @Route("/build/{id}", name="app_page_build", methods={"GET"})
     */
    public function build(int $id): Response
    {
        try {
            $content = $this->buildPageService->fetchContentPage((int) $id);
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
     * @Route("/save/{id}", name="app_page_save", methods={"POST"})
     */
    public function save(int $id, Request $request): JsonResponse
    {
        try {
            $content = $this->buildPageService->saveContentPage(
                (int) $id,
                $request->get('content'),
                $request->get('style'),
            );
        } catch (Exception $e) {
            $this->json(['error' => $e->getMessage()]);
        }

        return $this->json(['content' => $content]);
    }
}
