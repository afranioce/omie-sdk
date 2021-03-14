<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Client;

use DateTimeImmutable;
use Omie\Sdk\Entity\ActionableTrait;
use Omie\Sdk\Entity\BlamableTrait;
use Omie\Sdk\Entity\IdentifierTrait;
use Omie\Sdk\Entity\IntegrableTrait;
use Omie\Sdk\ValueConverter\BoolToStringConverter;
use Omie\Sdk\ValueConverter\StringToDateTimeImmutableConverter;

final class Client
{
    use IdentifierTrait;
    use ActionableTrait;
    use IntegrableTrait;
    use BlamableTrait;

    private const REGEX_MASK_CPF = '/^(\d{3})(\d{3})(\d{3})(\d{2})$/';
    private const REGEX_MASK_CNPJ = '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/';

    private string $fullname;

    private string $firstname;

    private string $lastname;

    private string $socialname;

    private string $email;

    /**
     * @var Tag[]
     */
    private array $tags;

    private string $cnpjCpf;

    private bool $isPerson;

    private ?Address $address;

    private ?Address $addressShipping;

    /**
     * @var Phone[]
     */
    private array $phones;

    public function __construct(
        ?int $id,
        string $integration,
        string $fullname,
        string $socialName,
        string $email,
        bool $active,
        array $tags,
        string $cnpjCpf,
        bool $isPerson,
        ?Address $address,
        ?Address $addressShipping,
        array $phones,
        DateTimeImmutable $createdAt,
        string $createdBy,
        DateTimeImmutable $updatedAt,
        string $updatedBy
    ) {
        $this->id = $id;
        $this->integration = $integration;
        $this->fullname = $fullname;
        $this->socialname = $socialName;
        $this->email = $email;
        $this->active = $active;
        $this->tags = $tags;
        $this->cnpjCpf = $cnpjCpf;
        $this->isPerson = $isPerson;
        $this->address = $address;
        $this->addressShipping = $addressShipping;
        $this->phones = $phones;
        $this->createdAt = $createdAt;
        $this->createdBy = $createdBy;
        $this->updatedAt = $updatedAt;
        $this->updatedBy = $updatedBy;

        list($this->firstname, $this->lastname) = explode(' ', $fullname, 2) + ['', 'Vazio'];
    }

    public function getFullname(): string
    {
        return $this->fullname;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getSocialname(): string
    {
        return $this->socialname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    public function getCnpjCpf(): string
    {
        return $this->cnpjCpf;
    }

    public function isPerson(): bool
    {
        return $this->isPerson;
    }

    public function getCnpjCpfNoMask(): string
    {
        return preg_replace('/\d/', '', $this->cnpjCpf);
    }

    public function getCnpjCpfMask(): string
    {
        return $this->isPerson()
            ? preg_replace(self::REGEX_MASK_CPF, '$1.$2.$3-$4', $this->cnpjCpf)
            : preg_replace(self::REGEX_MASK_CNPJ, '$1.$2.$3/$4-$5', $this->cnpjCpf);
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function getAddressShipping(): ?Address
    {
        return $this->addressShipping;
    }

    /**
     * @return Phone[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    public static function fromArray(array $data): self
    {
        $boolToStringValueConverter = new BoolToStringConverter();
        $stringToDatetimeImmutableConverter = new StringToDateTimeImmutableConverter('d/m/Y H:i:s');

        $tagsCollection = [];
        foreach ($data['tags'] as $tag) {
            $tagsCollection[] = new Tag($tag['tag']);
        }

        $phoneCollection = [];

        if (isset($data['telefone1_ddd']) && isset($data['telefone1_numero'])) {
            $phoneCollection[] = new Phone(
                $data['telefone1_ddd'],
                $data['telefone1_numero'],
            );
        }

        if (isset($data['telefone2_ddd']) && isset($data['telefone2_numero'])) {
            $phoneCollection[] = new Phone(
                $data['telefone2_ddd'],
                $data['telefone2_numero'],
            );
        }

        return new static(
            $data['codigo_cliente_omie'],
            $data['codigo_cliente_integracao'],
            $data['contato'] ?? $data['razao_social'] ?? '',
            $data['razao_social'] ?? '',
            $data['email'] ?? $data['codigo_cliente_omie'] . '@email.com',
            !((bool) $boolToStringValueConverter->fromModel($data['inativo'])),
            $tagsCollection,
            $data['cnpj_cpf'],
            $boolToStringValueConverter->fromModel($data['pessoa_fisica']),
            new Address(
                $data['endereco'] ?? '',
                $data['endereco_numero'] ?? '',
                empty($data['cep']) ? '00000000' : $data['cep'],
                Address::COUNTRY_BRAZIL_ID,
                $data['complemento'] ?? '',
                $data['bairro'] ?? '',
                $data['estado'] ?? '',
                empty($data['cidade']) ? 'Não Informada' : $data['cidade']
            ),
            empty($data['enderecoEntrega']) ? null : new Address(
                $data['enderecoEntrega']['entEndereco'] ?? '',
                $data['enderecoEntrega']['entNumero'] ?? '',
                empty($data['enderecoEntrega']['entCEP']) ? '00000000' : $data['enderecoEntrega']['entCEP'],
                Address::COUNTRY_BRAZIL_ID,
                $data['enderecoEntrega']['entComplemento'] ?? '',
                $data['enderecoEntrega']['entBairro'] ?? '',
                $data['enderecoEntrega']['entEstado'] ?? '',
                empty($data['enderecoEntrega']['entCidade']) ? 'Não Informada' : $data['enderecoEntrega']['entCidade']
            ),
            $phoneCollection,
            $stringToDatetimeImmutableConverter->fromModel($data['info']['dInc'] . ' ' . $data['info']['hInc']),
            $data['info']['uInc'],
            $stringToDatetimeImmutableConverter->fromModel($data['info']['dAlt'] . ' ' . $data['info']['hAlt']),
            $data['info']['uAlt']
        );
    }

    public function toArray(): array
    {
        $boolToStringValueConverter = new BoolToStringConverter();

        $array = [
            'codigo_cliente_omie' => $this->id,
            'codigo_cliente_integracao' => $this->integration,
            'bloquear_faturamento' => 'N',
            'cnpj_cpf' => $this->getCnpjCpfMask(),
            'contato' => $this->fullname,
            'razao_social' => $this->socialname,
            'email' => $this->email,
            'inativo' => $boolToStringValueConverter->fromProvider(!$this->active),
            'pessoa_fisica' => $boolToStringValueConverter->fromProvider($this->isPerson()),
            'tags' => array_map(fn (Tag $tag) => [
                'tag' => $tag->getName()
            ], $this->tags),
        ];

        if ($this->address) {
            $array += [
                'bairro' => $this->address->getDistrict(),
                'cep' => $this->address->getZipcode(),
                'cidade' => strtolower($this->address->getCity()) === 'não informada' ? '' : $this->address->getCity(),
                'codigo_pais' => $this->address->getCountry(),
                'complemento' => $this->address->getComplement(),
                'endereco' => $this->address->getStreet(),
                'endereco_numero' => $this->address->getNumber(),
                'estado' => $this->address->getRegionCode(),
            ];
        }

        if ($this->addressShipping) {
            $array['enderecoEntrega'] = [
                'entEndereco' => $this->addressShipping->getStreet(),
                'entNumero' => $this->addressShipping->getNumber(),
                'entComplemento' => $this->addressShipping->getComplement(),
                'entBairro' => $this->addressShipping->getDistrict(),
                'entCEP' => $this->addressShipping->getZipcode(),
                'entEstado' => $this->addressShipping->getRegionCode(),
                'entCidade' => strtolower($this->addressShipping->getCity()) === 'não informada'
                    ? ''
                    : $this->addressShipping->getCity(),
            ];
        }

        $array += array_map(fn (Phone $phone, int $index) => [
            sprintf('telefone%s_ddd', $index + 1) => $phone->getDdd(),
            sprintf('telefone%s_numero', $index + 1) => $phone->getNumber()
        ], $this->phones);

        return array_filter($array, fn($value) => $value !== null);
    }
}
