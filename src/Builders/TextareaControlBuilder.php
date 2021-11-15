<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseTextControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;

class TextareaControlBuilder extends BaseTextControlBuilder
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

    /**
     * Adds "cols" attribute to the textarea
     * @param  int  $numberOfCols
     * @return $this
     */
    public function withCols(int $numberOfCols): self
    {
        $this->config->setCols($numberOfCols);

        return $this;
    }

    /**
     * Adds "rows" attribute to the textarea
     * @param  int  $numberOfRows
     * @return $this
     */
    public function withRows(int $numberOfRows): self
    {
        $this->config->setRows($numberOfRows);

        return $this;
    }
}
