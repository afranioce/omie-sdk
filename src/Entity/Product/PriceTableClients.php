<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\Product;

final class PriceTableClients
{
    private bool $allClients;

    private string $regionName;

    private string $clientGroupName;

    private int $clientGroupId;

    public function __construct(bool $allClients, string $regionName, string $clientGroupName, int $clientGroupId)
    {
        $this->allClients = $allClients;
        $this->regionName = $regionName;
        $this->clientGroupName = $clientGroupName;
        $this->clientGroupId = $clientGroupId;
    }

    public function isAllClients(): bool
    {
        return $this->allClients;
    }

    public function getRegionCode(): string
    {
        return $this->regionName;
    }

    public function getClientGroupName(): string
    {
        return $this->clientGroupName;
    }

    public function getClientGroupId(): int
    {
        return $this->clientGroupId;
    }
}
