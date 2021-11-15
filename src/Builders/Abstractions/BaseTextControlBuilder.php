<?php

namespace Zhelyazko777\Forms\Builders\Abstractions;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseTextFormControlConfig;

abstract class BaseTextControlBuilder extends BaseControlBuilder
{
    /**
     * @var BaseTextFormControlConfig
     */
    protected BaseFormControlConfig $config;

    /**
     * Adds max length to the number of chars
     * @param  int  $value
     * @param  string|null  $message
     * @return $this
     * @throws \ReflectionException
     */
    public function maxLength(int $value, ?string $message = null): static
    {
        $this->config->setMaxLength($value);
        $this->addValidationRule("max:$value");

        return $this;
    }

    /**
     * Adds min length to the number of chars
     * @param  int  $value
     * @param  string|null  $message
     * @return $this
     * @throws \ReflectionException
     */
    public function minLength(int $value, ?string $message = null): static
    {
        $this->config->setMinLength($value);
        $this->addValidationRule("min:$value");

        return $this;
    }
}
