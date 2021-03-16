<?php

declare(strict_types=1);

namespace Omie\Sdk\Communication;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class OmieClient implements OmieClientInterface
{
    private ClientInterface $client;

    private LoggerInterface $logger;

    private AccessTokenInterface $authData;

    public function __construct(
        ClientInterface $client,
        AccessTokenInterface $authData,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->authData = $authData;
        $this->logger = $logger;
    }

    public function call(string $method, string $uri, array $parameters = []): ResponseInterface
    {
        $this->logger->info(
            sprintf(
                'Omie SDK call to method "%s"',
                $method
            ),
            $parameters
        );

        try {
            return $this->client->request(
                'POST',
                $uri,
                [
                    'json' => [
                        'app_key' => $this->authData->getAppKey(),
                        'app_secret' => $this->authData->getAppSecret(),
                        'call' => $method,
                        'param' => [$parameters]
                    ]
                ]
            );
        } catch (ClientException $exception) {
            $this->logger->error(
                sprintf(
                    'Omie SDK ClientException error: %s',
                    $exception->getMessage()
                )
            );

            throw $exception;
        }
    }
}
