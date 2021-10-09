<?php

namespace Zhelyazko777\Forms\Builders\Abstractions;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseTextFormControlConfig;

abstract class TextControlBuilder extends BaseControlBuilder
{
    /**
     * @var BaseTextFormControlConfig
     */
    protected BaseFormControlConfig $config;

    public function maxLength(int $value, ?string $message = null): static
    {
        $this->config->setMaxLength($value);
        $this->addValidationRule("max:$value");

        return $this;
    }

    public function minLength(int $value, ?string $message = null): static
    {
        $this->config->setMinLength($value);
        $this->addValidationRule("min:$value");

        return $this;
    }
}
