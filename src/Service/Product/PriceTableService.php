<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\Product;

use Omie\Sdk\Communication\OmieClientInterface;
use Omie\Sdk\PagedResult;
use Omie\Sdk\Entity\Product\PriceTable;

class PriceTableService implements PriceTableServiceInterface
{
    private const URI = 'produtos/tabelaprecos/';

    private const METHOD_LIST_PRICE_TABLES = 'ListarTabelasPreco';

    private OmieClientInterface $client;

    public function __construct(OmieClientInterface $client)
    {
        $this->client = $client;
    }

    public function getList(int $page = 1, $limit = 20): PagedResult
    {
        $response = $this->client->call(self::METHOD_LIST_PRICE_TABLES, self::URI, [
            'nPagina' => $page,
            'nRegPorPagina' => $limit,
        ]);

        $data = json_decode((string) $response->getBody(), true);

        return new PagedResult(
            $data['nPagina'],
            $data['nTotPaginas'],
            $this->transformFromArray($data['listaTabelasPreco'])
        );
    }

    private function transformFromArray(array $dataArray): array
    {
        $list = [];

        foreach ($dataArray as $row) {
            $list[] = PriceTable::fromArray($row);
        }

        return $list;
    }
}
