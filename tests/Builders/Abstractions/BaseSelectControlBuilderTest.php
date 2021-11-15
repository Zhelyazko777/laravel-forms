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

    public function test_add_fixed_options_should_add_static_options_to_the_config()
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

        $this->builder->addFixedOptions($options);

        /** @var BaseSelectFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals($options, $config->getFixedOptions());
    }

    public function test_add_model_should_set_correct_option_query_to_config()
    {
        $this->builder->addModel(Pet::class);

        /** @var BaseSelectFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals(Pet::query(), $config->getOptionsQuery());
    }

    public function test_add_model_with_callback_should_add_query_builder_to_config_query()
    {
        $whereRules = [1, '=', 1];

        $this->builder->addModel(Pet::class, fn (Builder $b) => $b->where($whereRules));

        /** @var BaseSelectFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals(Pet::query()->where($whereRules), $config->getOptionsQuery());
    }
}