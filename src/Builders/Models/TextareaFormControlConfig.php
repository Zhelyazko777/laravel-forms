<?php

namespace Zhelyazko777\Forms\Builders\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseTextFormControlConfig;

class TextareaFormControlConfig extends BaseTextFormControlConfig
{
    private ?int $rows = null;

    private ?int $cols = null;

    /**
     * @return ?int
     */
    public function getRows(): ?int
    {
        return $this->rows;
    }

    /**
     * @param  ?int  $rows
     * @return TextareaFormControlConfig
     */
    public function setRows(?int $rows): TextareaFormControlConfig
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return ?int
     */
    public function getCols(): ?int
    {
        return $this->cols;
    }

    /**
     * @param  ?int  $cols
     * @return TextareaFormControlConfig
     */
    public function setCols(?int $cols): TextareaFormControlConfig
    {
        $this->cols = $cols;
        return $this;
    }
}
