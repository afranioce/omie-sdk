<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\General;

use GuzzleHttp\Exception\GuzzleException;
use Omie\Sdk\PagedResult;

interface ProductServiceInterface
{
    /**
     * @throws GuzzleException
     */
    public function getList(int $page = 1, $limit = 50, array $filter = []): PagedResult;
}
