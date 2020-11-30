<?php

declare(strict_types=1);

namespace App\Service\ConstructorPage;

class ApiConstructorPage implements ConstructorPageInterface
{
    public function getContentPage(int $id): array
    {
        // TODO: logic to getting content page file_get_contents
        return [
            static::KEY_CONTENT => '',
            static::KEY_STYLE => '',
        ];
    }

    public function saveContentPage(int $id, string $content, string $style): array
    {
        // TODO: logic to getting content page

        return [
            'response' => ''
        ];
    }
}
