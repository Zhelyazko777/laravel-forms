<?php

namespace Zhelyazko777\Forms\Builders\Models\Abstractions;

abstract class BaseSelectFormControlConfig extends BaseFormControlConfig
{
    /**
     * @var array<mixed>
     */
    private array $fixedOptions = [];

    private string $optionValueProperty = 'id';

    private string $optionTextProperty = '';

    /**
     * @return string
     */
    public function getOptionValueProperty(): string
    {
        return $this->optionValueProperty;
    }

    /**
     * @param  string  $optionValueProperty
     * @return static
     */
    public function setOptionValueProperty(string $optionValueProperty): static
    {
        $this->optionValueProperty = $optionValueProperty;
        return $this;
    }

    /**
     * @return string
     */
    public function getOptionTextProperty(): string
    {
        return $this->optionTextProperty;
    }

    /**
     * @param  string  $optionTextProperty
     * @return static
     */
    public function setOptionTextProperty(string $optionTextProperty): static
    {
        $this->optionTextProperty = $optionTextProperty;
        return $this;
    }

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
