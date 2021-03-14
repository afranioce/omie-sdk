<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\Product\Order;

use Omie\Sdk\Entity\IntegrableTrait;

final class Item
{
    use IntegrableTrait;

    private const DISCOUNT_TYPE_VALUE = 'V';
    private const DISCOUNT_TYPE_PERCENT = 'P';

    private int $productId;

    private int $quantity;

    private float $unitPrice;

    private float $total;

    private float $weight;

    private float $amountDiscount;

    public function __construct(
        string $integration,
        int $productId,
        int $quantity,
        float $unitPrice,
        float $total,
        float $weight,
        float $amountDiscount = 0
    ) {
        $this->integration = $integration;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->total = $total;
        $this->weight = $weight;
        $this->amountDiscount = $amountDiscount;
    }


    public static function fromArray(array $data): self
    {
        return new Item(
            $data['ide']['codigo_item_integracao'],
            $data['produto']['codigo_produto'],
            $data['produto']['quantidade'],
            $data['produto']['valor_unitario'],
            $data['produto']['valor_total'],
            $data['produto']['valor_desconto'],
        );
    }

    public function toArray(): array
    {
        return [
            'ide' => [
                'codigo_item_integracao' => $this->integration,
            ],
            'inf_adic' => [
                'peso_bruto' => $this->weight,
                'peso_liquido' => $this->weight,
            ],
            'produto' => [
                'codigo_produto' => $this->productId,
                'quantidade' => $this->quantity,
                'tipo_desconto' => self::DISCOUNT_TYPE_VALUE,
                'valor_desconto' => $this->amountDiscount,
                'valor_unitario' => $this->unitPrice,
                'valor_total' => $this->total,
            ],
        ];
    }
}
