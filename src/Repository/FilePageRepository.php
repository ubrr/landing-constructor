<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\ConstructorPage\ConstructorPageInterface;
use App\Exceptions\FileContentPageException;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Exception;

class FilePageRepository implements PageRepositoryInterface
{
    private FilesystemInterface $publicUploadsFilesystem;

    public function __construct(FilesystemInterface $publicUploadsFilesystem)
    {
        $this->publicUploadsFilesystem = $publicUploadsFilesystem;
    }

    public function savePage(int $id, string $content, string $style): void
    {
        try {
            if (!$this->publicUploadsFilesystem->has(sprintf(static::PATH_FILE, $id))) {
                $this->publicUploadsFilesystem->write(
                    sprintf(static::PATH_FILE, $id),
                    json_encode([
                        ConstructorPageInterface::KEY_CONTENT => $content,
                        ConstructorPageInterface::KEY_STYLE => $style
                    ])
                );
            } else {
                $this->publicUploadsFilesystem->update(
                    sprintf(static::PATH_FILE, $id),
                    json_encode([
                        ConstructorPageInterface::KEY_CONTENT => $content,
                        ConstructorPageInterface::KEY_STYLE => $style
                    ])
                );
            }
        } catch (Exception $e) {
            throw new FileContentPageException($e->getMessage());
        }
    }

    public function getContentPage($id): array
    {
        try {
            if (!$this->publicUploadsFilesystem->has(sprintf(static::PATH_FILE, $id))) {
                return [];
            }

            $content = $this->publicUploadsFilesystem->read(sprintf(static::PATH_FILE, $id));

            return json_decode($content, true);
        } catch (Exception $e) {
            throw new FileContentPageException($e->getMessage());
        }
    }
}
