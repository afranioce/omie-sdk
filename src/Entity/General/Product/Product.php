<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Product;

use DateTimeImmutable;
use Omie\Sdk\Entity\ActionableTrait;
use Omie\Sdk\Entity\BlamableTrait;
use Omie\Sdk\Entity\General\Characteristic\Characteristic;
use Omie\Sdk\Entity\IdentifierTrait;
use Omie\Sdk\Entity\IntegrableTrait;
use Omie\Sdk\ValueConverter\BoolToStringConverter;
use Omie\Sdk\ValueConverter\StringToDateTimeImmutableConverter;

final class Product
{
    use IdentifierTrait;
    use ActionableTrait;
    use IntegrableTrait;
    use BlamableTrait;

    private string $sku;

    private string $name;

    private string $description;

    private string $brand;

    private float $price;

    private float $weight;

    private float $width;

    private float $height;

    private float $depth;

    private string $barCode;

    private int $stock;

    private Family $family;

    /**
     * @var Characteristic[]
     */
    private array $characteristics;

    /**
     * @var Image[]
     */
    private array $images;

    public function __construct(
        int $id,
        string $integration,
        string $sku,
        string $name,
        string $description,
        string $brand,
        float $price,
        float $weight,
        float $width,
        float $height,
        float $depth,
        string $barCode,
        int $stock,
        Family $family,
        array $characteristics,
        bool $active,
        DateTimeImmutable $createdAt,
        string $createdBy,
        DateTimeImmutable $updatedAt,
        string $updatedBy
    ) {
        $this->id = $id;
        $this->integration = $integration;
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->weight = $weight;
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
        $this->barCode = $barCode;
        $this->stock = $stock;
        $this->family = $family;
        $this->characteristics = $characteristics;
        $this->active = $active;
        $this->brand = $brand;
        $this->createdAt = $createdAt;
        $this->createdBy = $createdBy;
        $this->updatedAt = $updatedAt;
        $this->updatedBy = $updatedBy;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getDepth(): float
    {
        return $this->depth;
    }

    public function getBarCode(): string
    {
        return $this->barCode;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getFamily(): Family
    {
        return $this->family;
    }

    /**
     * @return Characteristic[]
     */
    public function getCharacteristics(): array
    {
        return $this->characteristics;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    public static function fromArray(array $data): Product
    {
        $stringToDatetimeImmutableConverter = new StringToDateTimeImmutableConverter('d/m/Y H:i:s');
        $boolToStringConverter = new BoolToStringConverter();

        $characteristicCollection = [];

        if (isset($data['caracteristicas'])) {
            foreach ($data['caracteristicas'] as $characteristic) {
                $characteristicCollection[] = new Characteristic(
                    $characteristic['nCodCaract'],
                    $characteristic['cNomeCaract'],
                    $characteristic['cConteudo']
                );
            }
        }

        $family = new Family($data['codigo_familia'], $data['descricao_familia']);

        return new static(
            $data['codigo_produto'],
            $data['codigo_produto_integracao'],
            $data['codigo'],
            $data['descricao'],
            $data['descr_detalhada'],
            $data['marca'],
            $data['valor_unitario'],
            $data['peso_bruto'],
            $data['largura'],
            $data['altura'],
            $data['profundidade'],
            $data['ean'],
            $data['quantidade_estoque'],
            $family,
            $characteristicCollection,
            !((bool) $boolToStringConverter->fromModel($data['inativo'])),
            $stringToDatetimeImmutableConverter->fromModel($data['info']['dInc'] . ' ' . $data['info']['hInc']),
            $data['info']['uInc'],
            $stringToDatetimeImmutableConverter->fromModel($data['info']['dAlt'] . ' ' . $data['info']['hAlt']),
            $data['info']['uAlt']
        );
    }
}
