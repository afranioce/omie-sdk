<?php

declare(strict_types=1);

namespace Omie\Sdk\Communication;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

final class OmieClient implements OmieClientInterface
{
    private ClientInterface $client;

    private string $appKey;

    private string $appSecret;

    private LoggerInterface $logger;

    public function __construct(
        ClientInterface $client,
        string $appKey,
        string $appSecret,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
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
                        'app_key' => $this->appKey,
                        'app_secret' => $this->appSecret,
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
