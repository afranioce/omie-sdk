<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Client;

final class Phone
{
    private string $ddd;

    private string $number;

    public function __construct(string $ddd, string $number)
    {
        $this->ddd = $ddd;
        $this->number = $number;
    }

    public static function empty(): Phone
    {
        return new self('00', '00000000');
    }

    public function getDdd(): string
    {
        return $this->ddd;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function format(): string
    {
        return $this->ddd . $this->number;
    }
}
