<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseSelectControlBuilder;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;

class SelectControlBuilder extends BaseSelectControlBuilder
{
    private string $existsRule;

    public function __construct(string $name)
    {
        $this->config = new SelectFormControlConfig();
        $this->existsRule = 'exists:' . $this->getFieldTableAndColumn($name);
        $this->addValidationRule($this->existsRule);
        parent::__construct($name);
    }

    public function useFixedOptions(array $options): static
    {
        $this->removeValidationRule($this->existsRule);
        return parent::useFixedOptions($options);
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
