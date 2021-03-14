<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\Product\Order;

use DateTimeInterface;
use Omie\Sdk\ValueConverter\StringToDateTimeImmutableConverter;

final class Installment
{
    private int $sequence;

    private DateTimeInterface $dueDate;

    private float $percent;

    private float $amount;

    public function __construct(int $sequence, DateTimeInterface $dueDate, float $percent, float $amount)
    {
        $this->sequence = $sequence;
        $this->dueDate = $dueDate;
        $this->percent = $percent;
        $this->amount = $amount;
    }

    public static function fromArray(array $data): self
    {
        $stringToDateTimeImmutableConverter = new StringToDateTimeImmutableConverter();
        return new Installment(
            (int) $data['numero_parcela'],
            $stringToDateTimeImmutableConverter->fromModel($data['data_vencimento']),
            (int) $data['percentual'],
            (float) $data['valor']
        );
    }

    public function toArray(): array
    {
        return [
            'numero_parcela' => $this->sequence,
            'data_vencimento' => $this->dueDate->format('d/m/Y'),
            'percentual' => $this->percent,
            'valor' => $this->amount,
        ];
    }
}
