<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\Error\RuntimeError;

class AssetIframeStyles extends AbstractExtension
{
    private const PATH_FILE_ASSET = __DIR__ . '/../../public/build/entrypoints.json';

    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset_css_iframe', [$this, 'assetEmbed'])
        ];
    }

    public function assetEmbed(): string
    {
        if (!file_exists(self::PATH_FILE_ASSET)) {
            throw new RuntimeError('File "'. self::PATH_FILE_ASSET . '" not found.');
        }

        $files = json_decode(file_get_contents(self::PATH_FILE_ASSET))
            ->entrypoints
            ->app
            ->css
        ;

        return json_encode($files, JSON_PRETTY_PRINT);
    }
}