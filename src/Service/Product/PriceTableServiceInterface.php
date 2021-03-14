<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\Product;

use Omie\Sdk\PagedResult;

interface PriceTableServiceInterface
{
    public function getList(int $page = 1, $limit = 20): PagedResult;
}
