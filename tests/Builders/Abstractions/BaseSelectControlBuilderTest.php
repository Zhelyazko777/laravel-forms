<?php

namespace Zhelyazko777\Forms\Tests\Builders\Abstractions;

use Illuminate\Database\Eloquent\Builder;
use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Abstractions\BaseSelectControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseSelectFormControlConfig;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

abstract class BaseSelectControlBuilderTest extends BaseControlBuilderTest
{
    /** @var BaseSelectControlBuilder */
    protected BaseControlBuilder $builder;

    public function test_use_fixed_options_should_add_fixed_options_to_the_config()
    {
        $options = [
            [
                'value' => 1,
                'text' => 'Test 1'
            ],
            [
                'value' => 2,
                'text' => 'Test 2'
            ],
        ];

        $this->builder->useFixedOptions($options);

        /** @var BaseSelectFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals($options, $config->getFixedOptions());
    }

    public function test_use_fetched_options_should_set_get_options_query_closure_to_config()
    {
        $this->builder->useFetchedOptions(fn (Builder $b) => $b->where([1, '=', 1]));

        /** @var BaseSelectFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertNotNull($config->getGetOptionsQuery());
    }
}