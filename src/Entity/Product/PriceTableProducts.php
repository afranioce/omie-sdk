<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\Product;

final class PriceTableProducts
{
    private string $content;

    private bool $allProducts;

    public function __construct(string $content, bool $allProducts)
    {
        $this->content = $content;
        $this->allProducts = $allProducts;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isAllProducts(): bool
    {
        return $this->allProducts;
    }
}
