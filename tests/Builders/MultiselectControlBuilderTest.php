<?php

namespace Zhelyazko777\Forms\Tests\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Builders\MultiselectControlBuilder;
use Zhelyazko777\Forms\Tests\Builders\Abstractions\BaseSelectControlBuilderTest;

class MultiselectControlBuilderTest extends BaseSelectControlBuilderTest
{
    /** @var MultiselectControlBuilder */
    protected BaseControlBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new MultiselectControlBuilder($this->fieldName);
    }

    public function test_soft_delete_connections_should_set_soft_delete_connections_to_true_in_config()
    {
        /** @var MultiselectFormControlConfig $config */
        $config = $this->builder->softDeleteConnections()->export();

        $this->assertTrue($config->getSoftDeleteConnections());
    }
}