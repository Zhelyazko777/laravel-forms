<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Models\SwitchFormControlConfig;

class SwitchControlBuilder extends BaseControlBuilder
{
    protected function getExportType(): string
    {
        return SwitchFormControlConfig::class;
    }
}
