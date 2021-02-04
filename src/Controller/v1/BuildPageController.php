<?php

declare(strict_types = 1);

namespace App\Controller\v1;

use App\Controller\BaseController;
use App\Factory\DesignPageReceiverFactory;
use App\Factory\ProductDesignPageFactory;
use App\Factory\DelayProductDesignFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;
use App\Exceptions\ApiConstructorPageException;

class BuildPageController extends BaseController
{
    /** @var ProductDesignPageFactory $productDesignPageFactory */
    private $productDesignPageFactory;

    /** @var DesignPageReceiverFactory $designPageReceiverFactory */
    private $designPageReceiverFactory;

    /** @var DelayProductDesignFactory $delayProductDesignFactory */
    private $delayProductDesignFactory;

    public function __construct(
        DesignPageReceiverFactory $designPageReceiverFactory,
        ProductDesignPageFactory $productDesignPageFactory,
        DelayProductDesignFactory $delayProductDesignFactory
    ) {
        $this->productDesignPageFactory = $productDesignPageFactory;
        $this->designPageReceiverFactory = $designPageReceiverFactory;
        $this->delayProductDesignFactory = $delayProductDesignFactory;
    }

    /**
     * @Route("/build/{id}", name="app_page_build", methods={"GET"})
     */
    public function build(int $id, Request $request): Response
    {
        $buildPageService = $this->designPageReceiverFactory->getDesignPageReceiver(
            (bool) $request->get('isEditDelayed')
        );

        try {
            $data = $buildPageService->getContentPage((int) $id);
            $data = $data['data'];
        } catch (Throwable $e) {
            return $this->render('error.html.twig', [
                'error' => $e->getMessage()
            ]);
        }

        return $this->render('buildPage/build.html.twig', [
            'id' => $id,
            'isEditDelayed' => $request->get('isEditDelayed'),
            'html' => $data['html'] ? html_entity_decode($data['html']) : $data['html'],
            'style' => $data['style'] ? html_entity_decode($data['style']) : $data['style']
        ]);
    }

    /**
     * @Route("/updateProductDesign/{id}", methods={"POST"})
     */
    public function updateProductDesign(int $id, Request $request): JsonResponse
    {
        $productDesignService = $this->productDesignPageFactory->getProductDesign();

        try {
            $response = $productDesignService->updateContentPage(
                (int) $id,
                $request->get('html'),
                $request->get('style')
            );

            return $this->successResponse($response);

        } catch (ApiConstructorPageException $e) {
            return $this->responseApiException($e->getMessage(), $e->getErrors(), $e->getCode());
        } catch (Throwable $e) {
            return $this->responseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @Route("/saveDelayDesign/{id}", methods={"POST"})
     */
    public function saveDelayDesign(int $id, Request $request): JsonResponse
    {
        $delayProductDesignService = $this->delayProductDesignFactory->getDelayProductDesign();

        try {
            $response = $delayProductDesignService->saveContentPage(
                (int) $id,
                $request->get('html'),
                $request->get('style'),
                $request->get('publicationTime')
            );

            return $this->successResponse($response);

        } catch (ApiConstructorPageException $e) {
            return $this->responseApiException($e->getMessage(), $e->getErrors(), $e->getCode());
        } catch (Throwable $e) {
            return $this->responseException($e->getMessage(), $e->getCode());
        }
    }
}
