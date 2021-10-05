<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\TextControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use App\Rules\Phone;

class InputControlBuilder extends TextControlBuilder
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

    public function validateAsNumber(): self
    {
        $this->config->setInputType('number');
        return $this;
    }

    public function validateAsPhone(?string $message = null): self
    {
        $this->addValidationRule(new Phone(), 'phone', $message);
        return $this;
    }

    public function greaterThanField(string $fieldName, ?string $message = null): self
    {
        $this->addValidationRule("gt:$fieldName", "max_min_price:@$fieldName", $message);
        return $this;
    }

    public function lowerThanField(string $fieldName, ?string $message = null): self
    {
        $this->addValidationRule("lt:$fieldName", "min_max_price:@$fieldName", $message);
        return $this;
    }
}
