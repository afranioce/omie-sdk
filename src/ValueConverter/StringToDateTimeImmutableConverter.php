<?php

declare(strict_types=1);

namespace Omie\Sdk\ValueConverter;

use DateTimeImmutable;

/**
 * @extends ValueConverter<string, ?\DateTimeImmutable>
 */
class StringToDateTimeImmutableConverter extends ValueConverter
{
    public function __construct(string $dateFormat = '!d/m/Y')
    {
        parent::__construct(
            fn (string $value) => !empty($value) ? DateTimeImmutable::createFromFormat($dateFormat, $value) : null,
            fn (?DateTimeImmutable $value) => $value !== null ? $value->format($dateFormat) : ''
        );
    }
}
