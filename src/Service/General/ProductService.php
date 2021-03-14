<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\General;

use Omie\Sdk\Communication\OmieClientInterface;
use Omie\Sdk\Entity\General\Product\Product;
use Omie\Sdk\PagedResult;

final class ProductService implements ProductServiceInterface
{
    private const URI = 'geral/produtos/';

    private const METHOD_LIST_PRODUCT = 'ListarProdutos';

    private OmieClientInterface $client;

    public function __construct(OmieClientInterface $client)
    {
        $this->client = $client;
    }

    public function getList(int $page = 1, $limit = 50, array $filter = []): PagedResult
    {
        $response = $this->client->call(self::METHOD_LIST_PRODUCT, self::URI, [
            'pagina' => $page,
            'registros_por_pagina' => $limit,
            'ordenar_por' => 'DATA_ALT',
            'ordem_decrescente' => 'N',
            'exibir_caracteristicas' => 'S',
            'filtrar_apenas_omiepdv' => 'N'
        ] + $filter);

        $data = json_decode((string) $response->getBody());

        return new PagedResult(
            $data['pagina'],
            $data['total_de_paginas'],
            $this->transformFromArray($data['produto_servico_cadastro'])
        );
    }

    private function transformFromArray(array $dataArray): array
    {
        $list = [];

        foreach ($dataArray as $row) {
            $list[] = Product::fromArray($row);
        }

        return $list;
    }
}
