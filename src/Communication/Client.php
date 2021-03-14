<?php

declare(strict_types=1);

namespace Omie\Sdk\Communication;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

final class Client extends HttpClient
{
    private const CLIENT_LOG = "Omie SDK Request: {request}\n\nResponse: {response}\n\nError: {error}";

    public function __construct(
        string $baseUri,
        LoggerInterface $logger,
        array $config = []
    ) {
        $config['base_uri'] = $baseUri;

        $handlerStack = $config['handler'] ?? HandlerStack::create();

        if (!isset($config['handler'])) {
            $handlerStack->push(Middleware::log($logger, new MessageFormatter(self::CLIENT_LOG)));
        }

        $config['handler'] = $handlerStack;

        parent::__construct($config);
    }
}
