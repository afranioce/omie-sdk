<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\Product\Order;

use DateTimeImmutable;
use Omie\Sdk\Entity\IdentifierTrait;
use Omie\Sdk\Entity\IntegrableTrait;
use Omie\Sdk\ValueConverter\StringToDateTimeImmutableConverter;

final class Order
{
    use IdentifierTrait;
    use IntegrableTrait;

    private const ORDER_ORIGIN = 'API';

    private const PAYMENT_FULL_CODE = '000';
    private const PAYMENT_INSTALLMENT_CODE = '999';

    private int $clientId;

    private string $category;

    private int $bankAccount;

    private DateTimeImmutable $previewDate;

    /**
     * @var Installment[]
     */
    private array $installments;

    private string $step;

    /**
     * @var Item[]
     */
    private array $items;

    private ?string $orderId;

    public function __construct(
        ?int $id,
        string $integration,
        int $clientId,
        string $category,
        int $bankAccount,
        DateTimeImmutable $previewDate,
        array $installments,
        string $step,
        array $items,
        ?string $orderId = null
    ) {
        $this->id = $id;
        $this->integration = $integration;
        $this->clientId = $clientId;
        $this->category = $category;
        $this->bankAccount = $bankAccount;
        $this->previewDate = $previewDate;
        $this->installments = $installments;
        $this->step = $step;
        $this->items = $items;
        $this->orderId = $orderId;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getPreviewDate(): DateTimeImmutable
    {
        return $this->previewDate;
    }

    /**
     * @return Installment[]
     */
    public function getInstallments(): array
    {
        return $this->installments;
    }

    public function getStep(): string
    {
        return $this->step;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public static function fromArray(array $data): Order
    {
        $stringToDateTimeImmutableConverter = new StringToDateTimeImmutableConverter();

        $installments = [];

        if (isset($data['lista_parcelas']['parcela'])) {
            foreach ($data['lista_parcelas']['parcela'] as $installmentArray) {
                $installments[] = Installment::fromArray($installmentArray);
            }
        }

        $items = [];

        foreach ($data['det'] as $itemArray) {
            $items[] = Item::fromArray($itemArray);
        }

        return new Order(
            $data['codigo_pedido'],
            $data['codigo_pedido_integracao'],
            $data['codigo_cliente'],
            $data['informacoes_adicionais']['codigo_categoria'],
            (int) $data['informacoes_adicionais']['codigo_conta_corrente'],
            $stringToDateTimeImmutableConverter->fromModel($data['data_previsao']),
            $installments,
            $data['etapa'],
            $items
        );
    }

    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function toArray(): array
    {
        return [
            'cabecalho' => [
                'codigo_pedido' => $this->id,
                'codigo_pedido_integracao' => $this->integration,
                'codigo_cliente' => $this->clientId,
                'data_previsao' => $this->previewDate->format('d/m/Y'),
                'etapa' => $this->step,
                'quantidade_itens' => count($this->items),
                'codigo_parcela' => count($this->installments) === 0
                    ? self::PAYMENT_FULL_CODE
                    : self::PAYMENT_INSTALLMENT_CODE,
                'origem_pedido' => self::ORDER_ORIGIN,
                'qtde_parcelas' => count($this->installments),
            ],
            'informacoes_adicionais' => [
                'codigo_categoria' => $this->category,
                'codigo_conta_corrente' => $this->bankAccount,
                'consumidor_final' => 'S',
                'enviar_email' => 'N',
            ],
            'det' => array_map(fn(Item $item) => $item->toArray(), $this->items),
            // TODO ver como fica a integração com o frete
//            'frete' => [
//                'modalidade' => '9',
//            ],
            'lista_parcelas' => [
                'parcela' => array_map(fn(Installment $installment) => $installment->toArray(), $this->installments),
            ],
        ];
    }
}
