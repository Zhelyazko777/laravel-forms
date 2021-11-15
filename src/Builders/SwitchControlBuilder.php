<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SwitchFormControlConfig;

class SwitchControlBuilder extends BaseControlBuilder
{
    public function __construct(string $name)
    {
        $this->config = new SwitchFormControlConfig();
        parent::__construct($name);
    }

    protected function getExportType(): string
    {
        return SwitchFormControlConfig::class;
    }
}
