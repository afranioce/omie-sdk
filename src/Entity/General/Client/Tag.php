<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Client;

final class Tag
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
