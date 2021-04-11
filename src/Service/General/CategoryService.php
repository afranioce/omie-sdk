<?php

namespace Omie\Sdk\Service\General;

use Omie\Sdk\Communication\OmieClientInterface;
use Omie\Sdk\Entity\General\Category\Category;
use Omie\Sdk\PagedResult;

class CategoryService implements CategoryServiceInterface
{
    private const URI = 'geral/categorias/';

    private const METHOD_LIST_CATEGORIES = 'ListarCategorias';

    private OmieClientInterface $client;

    public function __construct(OmieClientInterface $client)
    {
        $this->client = $client;
    }

    public function getList(int $page = 1, $limit = 100, array $filter = []): PagedResult
    {
        $response = $this->client->call(self::METHOD_LIST_CATEGORIES, self::URI, [
            'pagina' => $page,
            'registros_por_pagina' => $limit,
        ] + $filter);

        $data = json_decode((string) $response->getBody(), true);

        return new PagedResult(
            $data['pagina'],
            $data['total_de_paginas'],
            $this->transformFromArray($data['categoria_cadastro'])
        );
    }

    private function transformFromArray(array $dataArray): array
    {
        $list = [];

        foreach ($dataArray as $row) {
            $list[] = Category::fromArray($row);
        }

        return $list;
    }
}
