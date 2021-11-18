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

    /**
     * Adds the property which should be used for the value of the options
     * @param  string  $property
     * @return $this
     */
    public function valueProperty(string $property): static
    {
        $this->config->setOptionValueProperty($property);
        return $this;
    }

    /**
     * Adds the property which should be used for the text of the options
     * @param  string  $property
     * @return $this
     */
    public function textProperty(string $property): static
    {
        $this->config->setOptionTextProperty($property);
        return $this;
    }
}
