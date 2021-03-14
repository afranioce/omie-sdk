<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\Product;

use Omie\Sdk\Entity\ActionableTrait;
use Omie\Sdk\Entity\IdentifierTrait;
use Omie\Sdk\ValueConverter\BoolToStringConverter;
use Omie\Sdk\ValueConverter\StringToDateTimeImmutableConverter;

final class PriceTable
{
    use IdentifierTrait;
    use ActionableTrait;

    private string $code;

    private string $name;

    private string $priceTableId;

    private string $origin;

    private PriceTableCharacteristics $characteristics;

    private PriceTableProducts $products;

    private PriceTableClients $clients;

    public function __construct(
        int $id,
        string $code,
        bool $active,
        string $name,
        string $priceTableId,
        string $origin,
        PriceTableCharacteristics $characteristics,
        PriceTableProducts $products,
        PriceTableClients $clients
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->active = $active;
        $this->name = $name;
        $this->priceTableId = $priceTableId;
        $this->origin = $origin;
        $this->characteristics = $characteristics;
        $this->products = $products;
        $this->clients = $clients;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriceTableId(): string
    {
        return $this->priceTableId;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getCharacteristics(): PriceTableCharacteristics
    {
        return $this->characteristics;
    }

    public function getProducts(): PriceTableProducts
    {
        return $this->products;
    }

    public function getClients(): PriceTableClients
    {
        return $this->clients;
    }

    public static function fromArray(array $data): self
    {
        $boolToStringConverter = new BoolToStringConverter();
        $stringToDateTimeImmutableConverter = new StringToDateTimeImmutableConverter();

        return new self(
            (int) $data['nCodTabPreco'],
            $data['cCodigo'],
            (bool) $boolToStringConverter->fromModel($data['cAtiva']),
            $data['cNome'],
            $data['cCodIntTabPreco'],
            $data['cOrigem'],
            new PriceTableCharacteristics(
                (bool) $boolToStringConverter->fromModel($data['caracteristicas']['cArredPreco']),
                (bool) $boolToStringConverter->fromModel($data['caracteristicas']['cTemDesconto']),
                (bool) $boolToStringConverter->fromModel($data['caracteristicas']['cTemValidade']),
                $stringToDateTimeImmutableConverter->fromModel($data['caracteristicas']['dDtInicial']),
                $stringToDateTimeImmutableConverter->fromModel($data['caracteristicas']['dDtFinal']),
                (float) $data['caracteristicas']['nDescSugerido'],
                (float) $data['caracteristicas']['nPercDescMax']
            ),
            new PriceTableProducts(
                $data['produtos']['cConteudo'],
                (bool) $boolToStringConverter->fromModel($data['produtos']['cTodosProdutos']),
            ),
            new PriceTableClients(
                (bool) $boolToStringConverter->fromModel($data['clientes']['cTodosClientes']),
                $data['clientes']['cUF'],
                $data['clientes']['cTag'],
                $data['clientes']['nCodTag'],
            ),
        );
    }
}
