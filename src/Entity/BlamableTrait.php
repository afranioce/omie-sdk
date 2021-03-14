<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity;

use DateTimeImmutable;

trait BlamableTrait
{
    protected DateTimeImmutable $createdAt;

    protected string $createdBy;

    protected DateTimeImmutable $updatedAt;

    protected string $updatedBy;

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getUpdatedBy(): string
    {
        return $this->updatedBy;
    }
}
