<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseSelectControlBuilder;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;

class SelectControlBuilder extends BaseSelectControlBuilder
{
    public function __construct(string $name)
    {
        $this->config = new SelectFormControlConfig();
        $tableAndProp = $this->getFieldTableAndColumn($name);
        $this->addValidationRule("exists:$tableAndProp", '');

        parent::__construct($name);
    }

    private function getFieldTableAndColumn(string $propertyName): string
    {
        $propConnectionParts = explode(':', $propertyName);
        $tableReferencePropName = $propConnectionParts[count($propConnectionParts) - 1];
        $propParts = explode('_', $tableReferencePropName);
        $tablePropName = $propParts[count($propParts) - 1];
        $tableName = str_replace("_$tablePropName", '', $tableReferencePropName) . 's';

        return "$tableName,$tablePropName";
    }
}
