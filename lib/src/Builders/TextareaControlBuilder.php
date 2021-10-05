<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\TextControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;

class TextareaControlBuilder extends TextControlBuilder
{
    /**
     * @var TextareaFormControlConfig
     */
    protected BaseFormControlConfig $config;

    protected ?int $cols = null;

    protected ?int $rows = null;

    public function __construct(string $name)
    {
        $this->config = new TextareaFormControlConfig();
        parent::__construct($name);
    }

    public function withCols(int $numberOfCols): self
    {
        $this->config->setCols($numberOfCols);

        return $this;
    }

    public function withRows(int $numberOfRows): self
    {
        $this->config->setRows($numberOfRows);

        return $this;
    }
}
