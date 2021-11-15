<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseTextControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Rules\Phone;

class InputControlBuilder extends BaseTextControlBuilder
{
    /**
     * @var InputFormControlConfig
     */
    protected BaseFormControlConfig $config;

    protected string $inputType = 'text';

    public function __construct(string $name)
    {
        $this->config = new InputFormControlConfig();
        parent::__construct($name);
    }

    /**
     * Adds validation for a number and
     * makes the input type to "number"
     * @return $this
     */
    public function validateAsNumber(): self
    {
        $this->config->setInputType('number');
        return $this;
    }

    /**
     * Adds validation for Bulgarian phone number to the field
     * @param  string|null  $message
     * @return $this
     * @throws \ReflectionException
     */
    public function validateAsPhone(?string $message = null): self
    {
        $this->addValidationRule(new Phone, $message);
        return $this;
    }

    /**
     * Adds greater than other field validation
     * @param  string  $fieldName
     * @param  string|null  $message
     * @return $this
     * @throws \ReflectionException
     */
    public function greaterThanField(string $fieldName, ?string $message = null): self
    {
        $this->addValidationRule("gt:$fieldName", $message);
        return $this;
    }

    /**
     * Adds lower than other field validation
     * @param  string  $fieldName
     * @param  string|null  $message
     * @return $this
     * @throws \ReflectionException
     */
    public function lowerThanField(string $fieldName, ?string $message = null): self
    {
        $this->addValidationRule("lt:$fieldName", $message);
        return $this;
    }
}
