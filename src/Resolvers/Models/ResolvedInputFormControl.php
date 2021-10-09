<?php

namespace Zhelyazko777\Forms\Resolvers\Models;

use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedTextFormControl;

class ResolvedInputFormControl extends BaseResolvedTextFormControl
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
     * @return ResolvedInputFormControl
     */
    public function setInputType(string $inputType): ResolvedInputFormControl
    {
        $this->inputType = $inputType;
        return $this;
    }
}
