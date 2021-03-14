<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\Product;

use DateTimeImmutable;

final class PriceTableCharacteristics
{
    private bool $roundPrice;
    private bool $hasDiscount;
    private bool $hasValidate;
    private ?DateTimeImmutable $dateStart;
    private ?DateTimeImmutable $dateEnd;
    private float $discountSuggested;
    private float $maxDiscountPercent;

    public function __construct(
        bool $roundPrice,
        bool $hasDiscount,
        bool $hasValidate,
        ?DateTimeImmutable $dateStart,
        ?DateTimeImmutable $dateEnd,
        float $discountSuggested,
        float $maxDiscountPercent
    ) {
        $this->roundPrice = $roundPrice;
        $this->hasDiscount = $hasDiscount;
        $this->hasValidate = $hasValidate;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->discountSuggested = $discountSuggested;
        $this->maxDiscountPercent = $maxDiscountPercent;
    }

    public function isRoundPrice(): bool
    {
        return $this->roundPrice;
    }

    public function isHasDiscount(): bool
    {
        return $this->hasDiscount;
    }

    public function isHasValidate(): bool
    {
        return $this->hasValidate;
    }

    public function getDateStart(): ?DateTimeImmutable
    {
        return $this->dateStart;
    }

    public function getDateEnd(): ?DateTimeImmutable
    {
        return $this->dateEnd;
    }

    public function getDiscountSuggested(): float
    {
        return $this->discountSuggested;
    }

    public function getMaxDiscountPercent(): float
    {
        return $this->maxDiscountPercent;
    }
}
