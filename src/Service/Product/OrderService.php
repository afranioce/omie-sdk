<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\Product;

use Omie\Sdk\Communication\OmieClientInterface;
use Omie\Sdk\Entity\Product\Order\Order;

class OrderService implements OrderServiceInterface
{
    private const URI = 'produtos/pedido/';

    private const METHOD_CREATE_ORDER = 'IncluirPedido';

    private OmieClientInterface $client;

    public function __construct(OmieClientInterface $client)
    {
        $this->client = $client;
    }

    public function create(Order $order): Order
    {
        $response = $this->client->call(self::METHOD_CREATE_ORDER, self::URI, $order->toArray());

        $data = json_decode((string) $response->getBody(), true);

        $order->setId((int) $data['codigo_pedido']);
        $order->setOrderId(ltrim($data['numero_pedido'], '0'));

        return $order;
    }
}
