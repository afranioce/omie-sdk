<?php

namespace Omie\Sdk\Entity;

trait IdentifierTrait
{
    protected ?int $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
