<?php

namespace Zhelyazko777\Forms\Tests\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Builders\SelectControlBuilder;
use Zhelyazko777\Forms\Tests\Builders\Abstractions\BaseSelectControlBuilderTest;

class SelectControlBuilderTest extends BaseSelectControlBuilderTest
{
    /** @var SelectControlBuilder */
    protected BaseControlBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new SelectControlBuilder($this->fieldName);
    }

    public function test_export_should_return_select_form_control_instance()
    {
        $this->assertEquals(SelectFormControlConfig::class, get_class($this->builder->export()));
    }
}