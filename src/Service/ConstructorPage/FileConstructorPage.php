<?php

declare(strict_types=1);

namespace App\Service\ConstructorPage;

use App\Repository\FilePageRepository;

class FileConstructorPage implements ConstructorPageInterface
{
    private FilePageRepository $filePageRepository;

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

    public function saveContentPage(int $id, string $content, string $style): array
    {
        $this->filePageRepository->savePage($id, $content, $style);

        return [
            'response' => 'Content was saved'
        ];
    }
}
