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
     * @param  array<mixed>  $options
     * @return static
     */
    public function addFixedOptions(array $options): static
    {
        $this->config->setFixedOptions($options);
        return $this;
    }

    /**
     * @param  string  $model
     * @param  callable|null  $callback
     * @return static
     */
    public function addModel(string $model, ?callable $callback = null): static
    {
        $this->config->setOptionsQuery(call_user_func($model . '::query'));
        $this->config->setModel($model);

        if (!is_null($callback)) {
            $callback($this->config->getOptionsQuery());
        }

        return $this;
    }
}
