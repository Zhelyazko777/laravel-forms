<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseSelectControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;

class MultiselectControlBuilder extends BaseSelectControlBuilder
{
    /**
     * @var MultiselectFormControlConfig
     */
    protected BaseFormControlConfig $config;

    public function __construct(string $name)
    {
        $this->config = new MultiselectFormControlConfig();
        $this->addSingleValidationRule("exists:$name,id");

        parent::__construct($name);
    }

    protected function getExportType(): string
    {
        return MultiselectFormControlConfig::class;
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
