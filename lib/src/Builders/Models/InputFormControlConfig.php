<?php

namespace Zhelyazko777\Forms\Builders\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseTextFormControlConfig;

class InputFormControlConfig extends BaseTextFormControlConfig
{
    private string $inputType = '';

    /**
     * @return string
     */
    public function getInputType(): string
    {
        return $this->inputType;
    }

    /**
     * @param  string  $inputType
     * @return InputFormControlConfig
     */
    public function setInputType(string $inputType): InputFormControlConfig
    {
        $this->inputType = $inputType;
        return $this;
    }
}
