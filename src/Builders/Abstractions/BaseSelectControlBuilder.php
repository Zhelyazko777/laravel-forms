<?php

namespace Zhelyazko777\Forms\Builders\Abstractions;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseSelectFormControlConfig;

abstract class BaseSelectControlBuilder extends BaseControlBuilder
{
    /**
     * @var BaseSelectFormControlConfig
     */
    protected BaseFormControlConfig $config;

    /**
     * Adds a set of fixed options to the select
     * @param  array<mixed>  $options
     * @return static
     */
    public function useFixedOptions(array $options): static
    {
        $this->config->setFixedOptions($options);
        return $this;
    }

    /**
     * Adds query builder options to the query for fetching the options
     * @param  callable  $callback
     * @return $this
     */
    public function useFetchedOptions(callable $callback): static
    {
        if (!is_null($callback)) {
            $this->config->setGetOptionsQuery(\Closure::fromCallable($callback));
        }

        return $this;
    }
}
