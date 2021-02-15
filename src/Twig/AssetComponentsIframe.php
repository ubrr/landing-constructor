<?php

declare(strict_types = 1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Service\AssetService;
use Twig\Error\RuntimeError;
use Throwable;

class AssetComponentsIframe extends AbstractExtension
{
    private const ARRAY_KEY_ASSET_COMPONENTS = 'components';

    /** @var AssetService $assetService */
    private $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset_components_iframe', [$this, 'getAssetComponentsForIframe'])
        ];
    }

    public function getAssetComponentsForIframe(): string
    {
        try {
            $files = $this->assetService->getAssetsBySlug(
                self::ARRAY_KEY_ASSET_COMPONENTS,
                false
            );

            return json_encode($files, JSON_PRETTY_PRINT);

        } catch (Throwable $e) {
            throw new RuntimeError($e->getMessage());
        }
    }
}
