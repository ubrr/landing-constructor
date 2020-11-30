<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Controller\BaseController;
use App\Service\BuildPageService;
use App\Service\AuthManager\TokenAuthManager;
use App\Service\ConstructorPage\ApiConstructorPage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class BuildPageController extends BaseController
{
    private TokenAuthManager $tokenAuthManager;
    private ApiConstructorPage $apiConstructorPage;

    public function __construct(TokenAuthManager $tokenAuthManager, ApiConstructorPage $apiConstructorPage)
    {
        $this->tokenAuthManager = $tokenAuthManager;
        $this->apiConstructorPage = $apiConstructorPage;
    }

    /**
     * @Route("/build/{id}", name="app_page_build", methods={"GET"})
     */
    public function build(int $id): Response
    {
        try {
            $content = (new BuildPageService($this->tokenAuthManager, $this->apiConstructorPage))
                ->fetchContentPage((int) $id);
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
            $content = (new BuildPageService($this->tokenAuthManager, $this->apiConstructorPage))->saveContentPage(
                (int) $id,
                $request->get('content'),
                $request->get('style')
            );
        } catch (Exception $e) {
            $this->json(['error' => $e->getMessage()]);
        }

        return $this->json(['content' => $content]);
    }
}
