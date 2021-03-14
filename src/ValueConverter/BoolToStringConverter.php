<?php

declare(strict_types=1);

namespace Omie\Sdk\ValueConverter;

/**
 * @extends ValueConverter<bool, string>
 */
class BoolToStringConverter extends ValueConverter
{
    public function __construct(string $falseValue = 'N', string $trueValue = 'S')
    {
        parent::__construct(
            fn (string $value) => $value === $trueValue ? true : false,
            fn (bool $value) => $value === true ? $trueValue : $falseValue
        );
    }
}
