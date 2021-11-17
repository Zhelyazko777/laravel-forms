<?php

namespace Zhelyazko777\Forms\Builders;

use Illuminate\Support\Str;
use Zhelyazko777\Forms\Builders\Abstractions\BaseSelectControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;

class MultiselectControlBuilder extends BaseSelectControlBuilder
{
    /**
     * @var MultiselectFormControlConfig
     */
    protected BaseFormControlConfig $config;

    private string $existsRule;

    public function __construct(string $name)
    {
        $this->config = new MultiselectFormControlConfig();
        $tableName = Str::snake($name);
        $this->existsRule = "exists:$tableName,id";
        $this->addSingleValidationRule($this->existsRule);
        parent::__construct($name);
    }

    public function useFixedOptions(array $options): static
    {
        $this->removeSingleValidationRule($this->existsRule);
        return parent::useFixedOptions($options);
    }

    /**
     * Makes the delete of the connections "soft"
     * @return $this
     */
    public function softDeleteConnections(): self
    {
        $this->config->setSoftDeleteConnections(true);
        return $this;
    }
}
