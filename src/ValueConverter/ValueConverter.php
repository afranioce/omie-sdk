<?php

declare(strict_types=1);

namespace Omie\Sdk\ValueConverter;

use Closure;

/**
 * @template TModel
 * @template TProvider
 */
class ValueConverter
{
    private Closure $model;
    private Closure $provider;

    /**
     * ValueConverter constructor.
     * @param Closure(TModel): TProvider $model
     * @param Closure(TProvider): TModel $provider
     */
    public function __construct(Closure $model, Closure $provider)
    {
        $this->model = $model;
        $this->provider = $provider;
    }

    /**
     * @param TModel $value
     * @return TProvider
     */
    public function fromModel($value)
    {
        return $this->model->call($this, $value);
    }

    /**
     * @param TProvider $value
     * @return TModel
     */
    public function fromProvider($value)
    {
        return $this->provider->call($this, $value);
    }
}
