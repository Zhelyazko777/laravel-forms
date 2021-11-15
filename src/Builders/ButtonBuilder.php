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

    /**
     * Adds the button text
     * @param  string  $text
     * @return $this
     */
    public function addText(string $text): self
    {
        $this->config->setText($text);

        return $this;
    }

    /**
     * Exports the config object
     * @return ButtonFormControlConfig
     */
    public function export(): ButtonFormControlConfig
    {
        return $this->config;
    }
}
