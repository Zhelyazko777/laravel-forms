<?php

namespace Zhelyazko777\Forms\Tests\Builders\Abstractions;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\TestRule;

abstract class BaseControlBuilderTest extends TestCase
{
    protected BaseControlBuilder $builder;

    protected string $fieldName = 'test_field';

    public function test_take_columns_should_set_columns_to_take_to_config()
    {
        $numberOfColumns = 6;

        $this->builder->takeColumns($numberOfColumns);

        $this->assertEquals($numberOfColumns, $this->builder->export()->getColumnsToTake());
    }

    public function test_take_columns_should_set_columns_to_take_on_mobile_to_config()
    {
        $numberOfColumns = 6;

        $this->builder->takeColumns($numberOfColumns, $numberOfColumns);

        $this->assertEquals($numberOfColumns, $this->builder->export()->getColumnsToTakeOnMobile());
    }

    public function test_take_columns_without_number_of_mobile_columns_should_set_columns_to_take_on_mobile_12_to_config()
    {
        $this->builder->takeColumns(6);

        $this->assertEquals(12, $this->builder->export()->getColumnsToTakeOnMobile());
    }

    public function test_make_half_width_on_desktop_should_set_columns_to_take_to_6()
    {
        $this->builder->makeHalfWidthOnDesktop();

        $this->assertEquals(6, $this->builder->export()->getColumnsToTake());
    }

    public function test_make_half_width_on_desktop_should_not_change_mobile_columns()
    {
        $this->builder->makeHalfWidthOnDesktop();

        $this->assertEquals(12, $this->builder->export()->getColumnsToTakeOnMobile());
    }

    public function test_with_label_should_set_label_to_the_config()
    {
        $label = 'Test label';

        $this->builder->withLabel($label);

        $this->assertEquals($label, $this->builder->export()->getLabel());
    }

    public function test_with_value_should_set_value_to_the_config()
    {
        $value = 'Test';

        $this->builder->withValue($value);

        $this->assertEquals($value, $this->builder->export()->getValue());
    }

    public function test_make_required_should_add_required_rule_to_the_config()
    {
        $this->builder->makeRequired();

        $this->assertEquals('required', $this->builder->export()->getRules()[0]);
    }

    public function test_make_required_with_msg_should_add_msg_to_config()
    {
        $message = 'Custom test message';

        $this->builder->makeRequired($message);

        $this->assertEquals($message, current($this->builder->export()->getErrorMessages()));
    }

    public function test_disable_should_add_disabled_to_config()
    {
        $this->builder->disable();

        $this->assertTrue($this->builder->export()->getDisabled());
    }

    public function test_hide_should_add_hidden_to_config()
    {
        $this->builder->hide();

        $this->assertTrue($this->builder->export()->getHidden());
    }

    public function test_add_validation_rule_should_add_validation_rule_to_config()
    {
        $rule = 'required';

        $this->builder->addValidationRule($rule);

        $this->assertCount(1, $this->builder->export()->getRules());
        $this->assertEquals($rule, $this->builder->export()->getRules()[0]);
    }

    public function test_add_validation_rule_called_twice_with_same_rule_should_not_duplicate_rules_in_config()
    {
        $rule = 'required';

        $this->builder->addValidationRule($rule)->addValidationRule($rule);

        $this->assertCount(1, $this->builder->export()->getRules());
        $this->assertEquals($rule, $this->builder->export()->getRules()[0]);
    }

    public function test_add_validation_rule_called_multipel_times_with_different_rules_should_add_all_rules_to_config()
    {
        $rule = 'required';
        $secondRule = 'testRule';

        $this->builder->addValidationRule($rule)->addValidationRule($secondRule);

        $this->assertCount(2, $this->builder->export()->getRules());
        $this->assertEquals($rule, $this->builder->export()->getRules()[0]);
        $this->assertEquals($secondRule, $this->builder->export()->getRules()[1]);
    }

    public function test_add_validation_rule_with_msg_should_add_the_msg_to_config()
    {
        $msg = 'Some msg';
        $rule = 'required';

        $this->builder->addValidationRule($rule, $msg);

        $this->assertEquals([$this->fieldName . '.' . $rule => $msg], $this->builder->export()->getErrorMessages());
    }

    public function test_add_valdiation_rule_with_class_rule_and_msg_should_add_full_class_name_to_the_msgs_arr_in_the_config()
    {
        $msg = 'Some msg';
        $rule = TestRule::class;

        $this->builder->addValidationRule($rule, $msg);

        $this->assertEquals([$this->fieldName . '.' . $rule => $msg], $this->builder->export()->getErrorMessages());
    }

    public function test_add_validation_rule_with_argumentable_rule_and_msg_should_not_add_the_arguments_to_the_msgs_arr_in_the_config()
    {
        $msg = 'Some msg';
        $rule = 'exists';

        $this->builder->addValidationRule($rule . ':some_table,id', $msg);

        $this->assertEquals([$this->fieldName . '.' . $rule => $msg], $this->builder->export()->getErrorMessages());
    }

    public function test_add_single_validation_rule_should_add_validation_rule_to_config()
    {
        $rule = 'required';

        $this->builder->addSingleValidationRule($rule);

        $this->assertTrue(in_array($rule, $this->builder->export()->getSingleRules()));
    }

    public function test_add_single_validation_rule_called_twice_with_same_rule_should_not_duplicate_rules_in_config()
    {
        $rule = 'required';

        $this->builder->addSingleValidationRule($rule)->addSingleValidationRule($rule);

        $this->assertTrue(in_array($rule, $this->builder->export()->getSingleRules()));
    }

    public function test_add_single_validation_rule_called_multipel_times_with_different_rules_should_add_all_rules_to_config()
    {
        $rule = 'required';
        $secondRule = 'testRule';

        $this->builder->addSingleValidationRule($rule)->addSingleValidationRule($secondRule);

        $singleRules =  $this->builder->export()->getSingleRules();
        $this->assertTrue(in_array($rule, $singleRules));
        $this->assertTrue(in_array($secondRule, $singleRules));
    }

    public function test_add_single_validation_rule_with_msg_should_add_the_msg_to_config()
    {
        $msg = 'Some msg';
        $rule = 'required';

        $this->builder->addSingleValidationRule($rule, $msg);

        $this->assertEquals([$this->fieldName . '.*.' . $rule => $msg], $this->builder->export()->getErrorMessages());
    }

    public function test_add_single_valdiation_rule_with_class_rule_and_msg_should_add_full_class_name_to_the_msgs_arr_in_the_config()
    {
        $msg = 'Some msg';
        $rule = TestRule::class;

        $this->builder->addSingleValidationRule($rule, $msg);

        $this->assertEquals([$this->fieldName . '.*.' . $rule => $msg], $this->builder->export()->getErrorMessages());
    }

    public function test_add_single_validation_rule_with_argumentable_rule_and_msg_should_not_add_the_arguments_to_the_msgs_arr_in_the_config()
    {
        $msg = 'Some msg';
        $rule = 'exists';

        $this->builder->addSingleValidationRule($rule . ':some_table,id', $msg);

        $this->assertEquals([$this->fieldName . '.*.' . $rule => $msg], $this->builder->export()->getErrorMessages());
    }
}