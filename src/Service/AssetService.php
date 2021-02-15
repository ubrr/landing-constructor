<?php

declare(strict_types = 1);

namespace App\Service;

use App\Exceptions\NotFoundFileEntryPointsException;
use Symfony\Component\HttpFoundation\RequestStack;

class AssetService
{
    public const PATH_FILE_ASSETS = __DIR__ . '/../../public/build/entrypoints.json';
    private const PARENT_KEY_FILE_ASSETS = 'entrypoints';

    /** @var RequestStack $requestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getAssets(bool $isSetHostForAssets = true): array
    {
        $assets = $this->getAssetsFromFile();

        return $isSetHostForAssets ? $this->setHostForAssets($assets) : $assets;
    }

    public function getAssetsBySlug(string $slug, bool $isSetHostForAssets = true): array
    {
        $assets = $this->getAssetsFromFile();

        if (!empty($assets[$slug])) {
            return $isSetHostForAssets ? $this->setHostForAssets($assets[$slug]) : $assets[$slug];
        }

        return [];
    }

    private function getAssetsFromFile(): array
    {
        if (!is_readable(self::PATH_FILE_ASSETS)) {
            throw new NotFoundFileEntryPointsException(
                'Файл "'. self::PATH_FILE_ASSETS . '" не доступен.'
            );
        }

        $assets = file_get_contents(self::PATH_FILE_ASSETS);

        if ($assets) {
            $assets = json_decode($assets, true);

            return $assets[self::PARENT_KEY_FILE_ASSETS] ?? [];
        }

        return [];
    }

    private function setHostForAssets(array $assets): array
    {
        $url = $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost();

        foreach ($assets as $key => $asset) {
            if (empty($asset)) {
                continue;
            }

            $assets[$key] = array_map(static function ($path) use ($url) {
                return $url . $path;
            }, $asset);
        }

        return $assets;
    }
}
