<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Category;

final class Category
{
    private string $id;

    private string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['codigo'],
            $data['descricao']
        );
    }
}

