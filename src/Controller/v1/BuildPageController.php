<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Controller\BaseController;
use App\Service\BuildPageService;
use App\Service\Permission\PermissionService;
use App\Service\ConstructorPage\{
    ApiConstructorPage,
    FileConstructorPage
};
use App\Service\AuthManager\JwtTokenAuthenticator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Exception;

class BuildPageController extends BaseController
{
    private PermissionService $permissionService;
    private ApiConstructorPage $apiConstructorPage;
    private JwtTokenAuthenticator $jwtTokenAuthenticator;
    private FileConstructorPage $fileConstructorPage;

    public function __construct(
        PermissionService $permissionService,
        ApiConstructorPage $apiConstructorPage,
        JwtTokenAuthenticator $jwtTokenAuthenticator,
        FileConstructorPage $fileConstructorPage
    ) {
        $this->permissionService = $permissionService;
        $this->apiConstructorPage = $apiConstructorPage;
        $this->jwtTokenAuthenticator = $jwtTokenAuthenticator;
        $this->fileConstructorPage = $fileConstructorPage;
    }

    /**
     * @Route("/build/{id}", name="app_page_build", methods={"GET"})
     */
    public function build(int $id): Response
    {
        $buildPageService = new BuildPageService(
            $this->permissionService,
            $this->fileConstructorPage,
            $this->jwtTokenAuthenticator
        );

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
     * @Route("/save/{id}", name="app_page_save", methods={"POST"})
     */
    public function save(int $id, Request $request): JsonResponse
    {
        $buildPageService = new BuildPageService(
            $this->permissionService,
            $this->fileConstructorPage,
            $this->jwtTokenAuthenticator
        );

        try {
            $content = $buildPageService->saveContentPage(
                (int) $id,
                $request->get('content'),
                $request->get('style')
            );
        } catch (Exception $e) {
            return $this->json(['error' => $e->getMessage()]);
        }

        return $this->json(['content' => $content]);
    }
}
