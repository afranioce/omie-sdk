<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\BankAccount;

use Omie\Sdk\Entity\IdentifierTrait;

final class BankAccount
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

    public static function fromArray(array $data): self
    {
        return new self(
            $data['nCodCC'],
            $data['descricao']
        );
    }
}
