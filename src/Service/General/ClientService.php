<?php

declare(strict_types=1);

namespace Omie\Sdk\Service\General;

use GuzzleHttp\Exception\GuzzleException;
use Omie\Sdk\Communication\OmieClientInterface;
use Omie\Sdk\Entity\General\Client\Client;
use Omie\Sdk\PagedResult;

class ClientService implements ClientServiceInterface
{
    private const URI = 'geral/clientes/';

    private const METHOD_LIST_CLIENT = 'ListarClientes';
    private const METHOD_CREATE_CLIENT = 'IncluirCliente';
    private const METHOD_UPDATE_CLIENT = 'AlterarCliente';

    private OmieClientInterface $client;

    public function __construct(OmieClientInterface $client)
    {
        $this->client = $client;
    }

    public function getList(int $page = 1, $limit = 50, array $filter = []): PagedResult
    {
        $response = $this->client->call(self::METHOD_LIST_CLIENT, self::URI, [
            'pagina' => $page,
            'registros_por_pagina' => $limit,
        ] + $filter);

        $data = json_decode((string) $response->getBody(), true);

        return new PagedResult(
            $data['pagina'],
            $data['total_de_paginas'],
            $this->transformFromArray($data['clientes_cadastro'])
        );
    }

    public function create(Client $client): Client
    {
        return $this->save(self::METHOD_CREATE_CLIENT, $client);
    }

    public function update(Client $client): Client
    {
        return $this->save(self::METHOD_UPDATE_CLIENT, $client);
    }

    /**
     * @throws GuzzleException
     */
    private function save(string $method, Client $client): Client
    {
        $response = $this->client->call($method, self::URI, $client->toArray());

        $data = json_decode((string) $response->getBody());

        $client->setId((int) $data['codigo_cliente_omie']);

        return $client;
    }

    private function transformFromArray(array $dataArray): array
    {
        $list = [];

        foreach ($dataArray as $row) {
            $list[] = Client::fromArray($row);
        }

        return $list;
    }
}
