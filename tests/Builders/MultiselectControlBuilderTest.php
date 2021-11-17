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

    public function test_costructor_should_add_single_validation_rule_for_exist_by_default()
    {
        $this->assertCount(
            1,
            array_filter(
                (new MultiselectControlBuilder('test_table'))->export()->getSingleRules(),
                fn ($r) => str_starts_with($r, 'exists:'),
            )
        );
    }

    public function test_costructor_when_adding_single_validation_rule_for_exist_should_transform_table_name_to_snake_case()
    {
        $this->assertContains(
            'exists:test_relations,id',
            (new MultiselectControlBuilder('testRelations'))->export()->getSingleRules()
        );
    }

    public function test_soft_delete_connections_should_set_soft_delete_connections_to_true_in_config()
    {
        /** @var MultiselectFormControlConfig $config */
        $config = $this->builder->softDeleteConnections()->export();

        $this->assertTrue($config->getSoftDeleteConnections());
    }

    public function test_export_with_empty_string_passed_for_name_to_the_config_should_throw_invalid_argumnet_excpetion()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You should pass name different from whitespace for all of the form fields.');

        new MultiselectControlBuilder('');
    }
}