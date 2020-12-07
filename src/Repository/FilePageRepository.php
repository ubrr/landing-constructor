<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\ConstructorPage\ConstructorPageInterface;
use App\Exceptions\FileContentPageException;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Exception;

class FilePageRepository implements PageRepositoryInterface
{
    private FilesystemInterface $varUploadsFilesystem;

    public function __construct(FilesystemInterface $varUploadsFilesystem)
    {
        $this->varUploadsFilesystem = $varUploadsFilesystem;
    }

    public function savePage(int $id, string $content, string $style): void
    {
        try {
            $this->varUploadsFilesystem->put(
                sprintf(static::PATH_FILE, $id),
                json_encode([
                    ConstructorPageInterface::KEY_CONTENT => $content,
                    ConstructorPageInterface::KEY_STYLE => $style
                ])
            );
        } catch (Exception $e) {
            throw new FileContentPageException($e->getMessage());
        }
    }

    public function getContentPage($id): array
    {
        try {
            if (!$this->varUploadsFilesystem->has(sprintf(static::PATH_FILE, $id))) {
                return [];
            }

            $content = $this->varUploadsFilesystem->read(sprintf(static::PATH_FILE, $id));

            return json_decode($content, true);
        } catch (Exception $e) {
            throw new FileContentPageException($e->getMessage());
        }
    }
}
