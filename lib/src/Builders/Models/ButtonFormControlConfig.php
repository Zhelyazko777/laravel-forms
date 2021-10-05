<?php

namespace Zhelyazko777\Forms\Builders\Models;

use Zhelyazko777\Utilities\Exportable;

class ButtonFormControlConfig implements \JsonSerializable
{
    use Exportable;

    private string $text;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param  string  $text
     * @return ButtonFormControlConfig
     */
    public function setText(string $text): ButtonFormControlConfig
    {
        $this->text = $text;
        return $this;
    }
}
