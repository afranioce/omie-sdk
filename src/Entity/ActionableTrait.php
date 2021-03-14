<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity;

trait ActionableTrait
{
    protected bool $active;

    public function isActive(): bool
    {
        return $this->active;
    }
}
