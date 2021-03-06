<?php

namespace Zhelyazko777\Forms\Builders\Models\Abstractions;

abstract class BaseFormControlConfig
{
    private string $label = '';

    private int $columnsToTake = 12;

    private int $columnsToTakeOnMobile = 12;

    /** @var array<string|object> */
    private array $rules = [];

    /** @var array<string|object> */
    private array $singleRules = [];

    private string $name = '';

    private bool $disabled = false;

    private bool $hidden = false;

    /** @var array<string, string> */
    private array $errorMessages = [];

    private mixed $value = null;

    private ?\Closure $getOptionsQuery = null;

    /**
     * @return \Closure|null
     */
    public function getGetOptionsQuery(): ?\Closure
    {
        return $this->getOptionsQuery;
    }

    /**
     * @param  \Closure|null  $getOptionsQuery
     * @return static
     */
    public function setGetOptionsQuery(?\Closure $getOptionsQuery): static
    {
        $this->getOptionsQuery = $getOptionsQuery;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param  mixed  $value
     * @return static
     */
    public function setValue(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHidden(): bool
    {
        return $this->hidden;
    }

    /**
     * @param  bool  $hidden
     * @return static
     */
    public function setHidden(bool $hidden): static
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @param  string[]  $errorMessages
     * @return static
     */
    public function setErrorMessages(array $errorMessages): static
    {
        $this->errorMessages = $errorMessages;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param  string  $label
     * @return static
     */
    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return int
     */
    public function getColumnsToTake(): int
    {
        return $this->columnsToTake;
    }

    /**
     * @param  int  $columnsToTake
     * @return static
     */
    public function setColumnsToTake(int $columnsToTake): static
    {
        $this->columnsToTake = $columnsToTake;
        return $this;
    }

    /**
     * @return int
     */
    public function getColumnsToTakeOnMobile(): int
    {
        return $this->columnsToTakeOnMobile;
    }

    /**
     * @param  int  $columnsToTakeOnMobile
     * @return static
     */
    public function setColumnsToTakeOnMobile(int $columnsToTakeOnMobile): static
    {
        $this->columnsToTakeOnMobile = $columnsToTakeOnMobile;
        return $this;
    }

    /**
     * @return array<string|object>
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param  array<string|object>  $rules
     * @return static
     */
    public function setRules(array $rules): static
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function getDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param  bool  $disabled
     * @return static
     */
    public function setDisabled(bool $disabled): static
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function getType(): string
    {
        $classParts = explode('\\', get_class($this));
        $name = $classParts[count($classParts) - 1];

        return lcfirst(str_replace('FormControlConfig', '', $name));
    }

    /**
     * @return array<string|object>
     */
    public function getSingleRules(): array
    {
        return $this->singleRules;
    }

    /**
     * @param  array<string>  $singleRules
     * @return static
     */
    public function setSingleRules(array $singleRules): static
    {
        $this->singleRules = $singleRules;
        return $this;
    }
}
