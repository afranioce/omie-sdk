<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Product;

use Omie\Sdk\Entity\IdentifierTrait;

final class Family
{
    use IdentifierTrait;

    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
