<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseSelectControlBuilder;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;

class SelectControlBuilder extends BaseSelectControlBuilder
{
    public function __construct(string $name)
    {
        $this->config = new SelectFormControlConfig();
        parent::__construct($name);
    }
}
