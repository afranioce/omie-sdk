<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\General;

use Omie\Sdk\Communication\OmieClientInterface;
use Omie\Sdk\Entity\General\Characteristic\Characteristic;
use Omie\Sdk\PagedResult;

class CharacteristicService implements CharacteristicServiceInterface
{
    private const URI = 'geral/caracteristicas/';

    private const METHOD_LIST_CHARACTERISTIC = 'ListarCaracteristicas';

    private OmieClientInterface $client;

    public function __construct(OmieClientInterface $client)
    {
        $this->client = $client;
    }

    public function getList(int $page = 1, $limit = 50, array $filter = []): PagedResult
    {
        $response = $this->client->call(self::METHOD_LIST_CHARACTERISTIC, self::URI, [
            'nPagina' => $page,
            'nRegPorPagina' => $limit,
        ] + $filter);

        $data = json_decode((string) $response->getBody(), true);

        return new PagedResult(
            $data['nPagina'],
            $data['nTotPaginas'],
            $this->transformFromArray($data['listaCaracteristicas'])
        );
    }

    private function transformFromArray(array $dataArray): array
    {
        $list = [];

        foreach ($dataArray as $row) {
            $list[] = Characteristic::fromArray($row);
        }

        return $list;
    }
}
