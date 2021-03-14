<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\General;

use GuzzleHttp\Exception\GuzzleException;
use Omie\Sdk\Entity\General\Client\Client;
use Omie\Sdk\PagedResult;

interface ClientServiceInterface
{
    /**
     * @throws GuzzleException
     */
    public function getList(int $page = 1, $limit = 50, array $filter = []): PagedResult;

    /**
     * @throws GuzzleException
     */
    public function create(Client $client): Client;

    /**
     * @throws GuzzleException
     */
    public function update(Client $client): Client;
}
