<?php

namespace Zhelyazko777\Forms\Resolvers\Models;

use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedTextFormControl;

class ResolvedTextareaFormControl extends BaseResolvedTextFormControl
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
     * @return ResolvedTextareaFormControl
     */
    public function setRows(?int $rows): ResolvedTextareaFormControl
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return int
     */
    public function getCols(): ?int
    {
        return $this->cols;
    }

    /**
     * @param  int  $cols
     * @return ResolvedTextareaFormControl
     */
    public function setCols(?int $cols): ResolvedTextareaFormControl
    {
        $this->cols = $cols;
        return $this;
    }
}
