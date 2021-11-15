<?php

namespace Zhelyazko777\Forms\Tests\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;
use Zhelyazko777\Forms\Builders\TextareaControlBuilder;
use Zhelyazko777\Forms\Tests\Builders\Abstractions\BaseTextControlBuilderTest;

class TextareaControlBuilderTest extends BaseTextControlBuilderTest
{
    /** @var TextareaControlBuilder */
    protected BaseControlBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new TextareaControlBuilder($this->fieldName);
    }

    public function test_with_cols_should_add_cols_to_the_config()
    {
        $cols = 5;

        /** @var TextareaFormControlConfig $config */
        $config = $this->builder->withCols($cols)->export();

        $this->assertEquals($cols, $config->getCols());
    }

    public function test_with_rows_should_add_rows_to_the_config()
    {
        $rows = 5;

        /** @var TextareaFormControlConfig $config */
        $config = $this->builder->withRows($rows)->export();

        $this->assertEquals($rows, $config->getRows());
    }
}