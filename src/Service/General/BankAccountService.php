<?php

namespace Omie\Sdk\Service\General;

use Omie\Sdk\Communication\OmieClientInterface;
use Omie\Sdk\Entity\General\BankAccount\BankAccount;
use Omie\Sdk\PagedResult;

class BankAccountService implements BankAccountServiceInterface
{
    private const URI = 'geral/contacorrente/';

    private const METHOD_LIST_BANK_ACCOUNTS = 'ListarContasCorrentes';

    private OmieClientInterface $client;

    public function __construct(OmieClientInterface $client) {
        $this->client = $client;
    }

    public function getList(int $page = 1, $limit = 100, array $filter = []): PagedResult
    {
        $response = $this->client->call(self::METHOD_LIST_BANK_ACCOUNTS, self::URI, [
            'pagina' => $page,
            'registros_por_pagina' => $limit,
            'apenas_importado_api' => 'N',
        ] + $filter);

        $data = json_decode((string) $response->getBody(), true);

        return new PagedResult(
            $data['pagina'],
            $data['total_de_paginas'],
            $this->transformFromArray($data['ListarContasCorrentes'])
        );
    }

    private function transformFromArray(array $dataArray): array
    {
        $list = [];

        foreach ($dataArray as $row) {
            $list[] = BankAccount::fromArray($row);
        }

        return $list;
    }
}
