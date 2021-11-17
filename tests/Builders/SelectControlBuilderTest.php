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

    public function test_costructor_should_add_validation_rule_for_exist_by_default()
    {
        $this->assertCount(
            1,
            array_filter(
                (new SelectControlBuilder('test_table_id'))->export()->getRules(),
                fn ($r) => str_starts_with($r, 'exists:'),
            )
        );
    }

    public function test_costructor_when_adding_validation_rule_for_exist_should_add_s_char_at_table_end()
    {
        $this->assertContains(
            'exists:test_tables,id',
            (new SelectControlBuilder('test_table_id'))->export()->getRules()
        );
    }

    public function test_costructor_when_adding_validation_rule_for_exist_should_add_ies_chars_at_table_end_if_it_ends_with_y_char()
    {
        $this->assertContains(
            'exists:test_tablies,id',
            (new SelectControlBuilder('test_tably_id'))->export()->getRules()
        );
    }

    public function test_export_should_return_select_form_control_instance()
    {
        $this->assertEquals(SelectFormControlConfig::class, get_class($this->builder->export()));
    }

    public function test_export_with_empty_string_passed_for_name_to_the_config_should_throw_invalid_argumnet_excpetion()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('You should pass name different from whitespace for all of the form fields.');

        new SelectControlBuilder('');
    }
}