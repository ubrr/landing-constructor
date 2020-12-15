<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\ConstructorPage\ConstructorPageInterface;
use App\Exceptions\FileContentPageException;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Exception;

class FilePageRepository implements PageRepositoryInterface
{
    /** @var FilesystemInterface $varUploadsFilesystem */
    private $varUploadsFilesystem;

    public function __construct(FilesystemInterface $varUploadsFilesystem)
    {
        $this->varUploadsFilesystem = $varUploadsFilesystem;
    }

    public function updatePage(int $id, string $content, string $style): void
    {
        $this->varUploadsFilesystem->put(
            sprintf(static::PATH_FILE, $id),
            json_encode([
                ConstructorPageInterface::KEY_CONTENT => $content,
                ConstructorPageInterface::KEY_STYLE => $style
            ])
        );
    }

    public function getContentPage(int $id): array
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
