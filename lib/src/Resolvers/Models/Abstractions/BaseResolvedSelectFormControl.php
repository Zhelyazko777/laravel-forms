<?php

namespace Zhelyazko777\Forms\Resolvers\Models\Abstractions;

abstract class BaseResolvedSelectFormControl extends BaseResolvedFormControl
{
    /**
     * @var array<string, string|int>
     */
    private array $options = [];

    /**
     * @return array<string, string|int>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param  array<string, string|int>  $options
     * @return static
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;
        return $this;
    }
}
