<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Models\ButtonFormControlConfig;
use Zhelyazko777\Utilities\Contracts\CanExport;

class ButtonBuilder implements CanExport
{
    private ButtonFormControlConfig $config;

    public function __construct()
    {
        $this->config = new ButtonFormControlConfig();
    }

    public function addText(string $text): self
    {
        $this->config->setText($text);

        return $this;
    }

    public function export(): ButtonFormControlConfig
    {
        return $this->config;
    }
}
