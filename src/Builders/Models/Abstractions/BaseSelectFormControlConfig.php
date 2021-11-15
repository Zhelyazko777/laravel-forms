<?php

namespace Zhelyazko777\Forms\Builders\Models\Abstractions;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseSelectFormControlConfig extends BaseFormControlConfig
{
    /**
     * @var array<mixed>
     */
    private array $fixedOptions = [];

    private ?Builder $optionsQuery = null;

    private ?string $model = null;

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

    /**
     * @return Builder|null
     */
    public function getOptionsQuery(): ?Builder
    {
        return $this->optionsQuery;
    }

    /**
     * @param  Builder|null  $optionsQuery
     * @return BaseSelectFormControlConfig
     */
    public function setOptionsQuery(?Builder $optionsQuery): BaseSelectFormControlConfig
    {
        $this->optionsQuery = $optionsQuery;
        return $this;
    }
}
