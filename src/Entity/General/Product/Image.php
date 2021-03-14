<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Product;

final class Image
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
