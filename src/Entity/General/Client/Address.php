<?php

declare(strict_types=1);

namespace Omie\Sdk\Entity\General\Client;

final class Address
{
    public const COUNTRY_BRAZIL_ID = '1058';

    private string $street;

    private string $number;

    private string $zipcode;

    private string $country;

    private string $complement;

    private string $district;

    private string $regionCode;

    private string $city;

    public function __construct(
        string $street,
        string $number,
        string $zipcode,
        string $country,
        string $complement,
        string $district,
        string $regionCode,
        string $city
    ) {
        $this->street = $street;
        $this->number = $number;
        $this->zipcode = $zipcode;
        $this->country = $country;
        $this->complement = $complement;
        $this->district = $district;
        $this->regionCode = $regionCode;
        $this->city = $city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getComplement(): string
    {
        return $this->complement;
    }

    public function getDistrict(): string
    {
        return $this->district;
    }

    public function getRegionCode(): string
    {
        return $this->regionCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}
