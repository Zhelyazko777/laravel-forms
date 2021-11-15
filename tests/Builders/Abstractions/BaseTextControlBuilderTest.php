<?php

namespace Zhelyazko777\Forms\Tests\Builders\Abstractions;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Abstractions\BaseTextControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseTextFormControlConfig;

abstract class BaseTextControlBuilderTest extends BaseControlBuilderTest
{
    /** @var BaseTextControlBuilder */
    protected BaseControlBuilder $builder;

    public function test_max_length_should_set_max_length_to_config()
    {
        $length = 5;

        $this->builder->maxLength(5);

        /** @var BaseTextFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals($length, $config->getMaxLength());
    }

    public function test_min_length_should_set_min_length_to_config()
    {
        $length = 5;

        $this->builder->minLength(5);

        /** @var BaseTextFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals($length, $config->getMinLength());
    }
}