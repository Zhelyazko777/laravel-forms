<?php

namespace Zhelyazko777\Forms\Builders\Models\Abstractions;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseSelectFormControlConfig extends BaseFormControlConfig
{
    /**
     * @var array<mixed>
     */
    private array $fixedOptions = [];

    /**
     * @return array<mixed>
     */
    public function getFixedOptions(): array
    {
        return $this->fixedOptions;
    }

    /**
     * @param  array<mixed>  $fixedOptions
     * @return BaseSelectFormControlConfig
     */
    public function setFixedOptions(array $fixedOptions): BaseSelectFormControlConfig
    {
        $this->fixedOptions = $fixedOptions;
        return $this;
    }
}
