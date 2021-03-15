<?php

namespace Omie\Sdk\Communication;

interface AuthDataInterface
{
    public function getAppKey(): string;

    public function getAppSecret(): string;
}
