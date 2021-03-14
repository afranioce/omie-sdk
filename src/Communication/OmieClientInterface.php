<?php

declare(strict_types=1);

namespace Omie\Sdk\Communication;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

interface OmieClientInterface
{
    /**
     * @throws GuzzleException
     */
    public function call(string $method, string $uri, array $parameters = []): ResponseInterface;
}
