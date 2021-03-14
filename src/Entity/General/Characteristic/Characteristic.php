<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Characteristic;

use Omie\Sdk\Entity\IdentifierTrait;

final class Characteristic
{
    use IdentifierTrait;

    private string $name;

    private string $value;

    public function __construct(int $id, string $name, string $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function fromArray(array $data)
    {
        return new static(
            $data['nCodCaract'],
            $data['cNomeCaract'],
            $data['cConteudo'] ?? ''
        );
    }
}
