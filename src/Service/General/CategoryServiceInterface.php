<?php

namespace Omie\Sdk\Service\General;

use GuzzleHttp\Exception\GuzzleException;
use Omie\Sdk\PagedResult;

interface CategoryServiceInterface
{
    /**
     * @throws GuzzleException
     */
    public function getList(int $page = 1, $limit = 100, array $filter = []): PagedResult;
}
