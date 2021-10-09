<?php

namespace Zhelyazko777\Forms\Builders\Models\Abstractions;

abstract class BaseTextFormControlConfig extends BaseFormControlConfig
{
    private ?int $maxLength = null;

    private ?int $minLength = null;

    /**
     * @return int
     */
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    /**
     * @param  ?int  $maxLength
     * @return static
     */
    public function setMaxLength(?int $maxLength): static
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    /**
     * @param  ?int  $minLength
     * @return static
     */
    public function setMinLength(?int $minLength): static
    {
        $this->minLength = $minLength;
        return $this;
    }
}
