<?php

declare(strict_types=1);

namespace Omie\Sdk\Communication;

interface UrlInterface
{
    public function getBaseUri(): string;
}
