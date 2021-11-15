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
    public function addFixedOptions(array $options): static
    {
        $this->config->setFixedOptions($options);
        return $this;
    }

    /**
     * Adds the model from which the select
     * options will be fetched
     * @param  string  $model
     * @param  callable|null  $callback
     * @return static
     * @throws \ReflectionException
     */
    public function addModel(string $model, ?callable $callback = null): static
    {
        $this->config->setOptionsQuery(call_user_func($model . '::query'));
        $tableAndProp = $this->getFieldTableAndColumn($this->config->getName());
        $this->addValidationRule("exists:$tableAndProp");

        if (!is_null($callback)) {
            $callback($this->config->getOptionsQuery());
        }

        return $this;
    }

    private function getFieldTableAndColumn(string $propertyName): string
    {
        $propConnectionParts = explode(':', $propertyName);
        $tableReferencePropName = $propConnectionParts[count($propConnectionParts) - 1];
        $propParts = explode('_', $tableReferencePropName);
        $tablePropName = $propParts[count($propParts) - 1];
        $tableName = str_replace("_$tablePropName", '', $tableReferencePropName);

        if (str_ends_with($tableName, 'y')) {
            $tableName = rtrim($tableName, 'y') . 'ies';
        } else {
            $tableName .= 's';
        }

        return "$tableName,$tablePropName";
    }
}
