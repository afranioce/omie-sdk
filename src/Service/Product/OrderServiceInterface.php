<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\Product;

use GuzzleHttp\Exception\GuzzleException;
use Omie\Sdk\Entity\Product\Order\Order;

interface OrderServiceInterface
{
    /**
     * @throws GuzzleException
     */
    public function create(Order $order): Order;
}
