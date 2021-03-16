<?php

namespace Omie\Sdk\Communication;

interface AccessTokenInterface
{
    public function getAppKey(): string;

    public function getAppSecret(): string;
}
