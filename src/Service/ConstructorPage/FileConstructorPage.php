<?php

declare(strict_types=1);

namespace App\Service\ConstructorPage;

use App\Repository\FilePageRepository;

class FileConstructorPage implements ConstructorPageInterface
{
    /** @var FilePageRepository $filePageRepository */
    private $filePageRepository;

    public function __construct(FilePageRepository $filePageRepository)
    {
        $this->filePageRepository = $filePageRepository;
    }

    public function getContentPage(int $id): array
    {
        $content = $this->filePageRepository->getContentPage($id);

        return [
            static::KEY_CONTENT => $content[static::KEY_CONTENT] ?? '',
            static::KEY_STYLE => $content[static::KEY_STYLE] ?? '',
        ];
    }

    public function updateContentPage(int $id, string $content, string $style): array
    {
        $this->filePageRepository->updatePage($id, $content, $style);

        return [
            'response' => 'Content was updated'
        ];
    }
}
