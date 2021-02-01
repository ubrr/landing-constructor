<?php

declare(strict_types=1);

namespace App\Controller\v1;

use App\Controller\BaseController;
use App\Factory\BuildPageFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

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
            $data = $buildPageService->fetchContentPage((int) $id);
            $data = $data['data'];
        } catch (Throwable $e) {
            return $this->render('error.html.twig', [
                'error' => $e->getMessage()
            ]);
        }

        return $this->render('buildPage/build.html.twig', [
            'id' => $id,
            'html' => $data['html'] ? html_entity_decode($data['html']) : $data['html'],
            'style' => $data['style'] ? html_entity_decode($data['style']) : $data['style']
        ]);
    }

    /**
     * @Route("/update/{id}", name="app_page_update", methods={"POST"})
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $buildPageService = $this->buildPageFactory->getBuildPage();

        try {
            $response = $buildPageService->updateContentPage(
                (int) $id,
                $request->get('html'),
                $request->get('style')
            );

            return $this->successResponse($response);

        } catch (Throwable $e) {
            return $this->responseException($e->getMessage(), $e->getCode());
        }
    }
}
