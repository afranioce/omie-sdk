<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity;

trait IntegrableTrait
{
    protected string $integration;

    public function getIntegration(): string
    {
        return $this->integration;
    }
}
