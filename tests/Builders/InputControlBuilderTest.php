<?php

namespace Zhelyazko777\Forms\Tests\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\InputControlBuilder;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Rules\Phone;
use Zhelyazko777\Forms\Tests\Builders\Abstractions\BaseTextControlBuilderTest;

class InputControlBuilderTest extends BaseTextControlBuilderTest
{
    /** @var InputControlBuilder */
    protected BaseControlBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new InputControlBuilder($this->fieldName);
    }

    public function test_export_should_return_select_form_control_instance()
    {
        $this->assertEquals(InputFormControlConfig::class, get_class($this->builder->export()));
    }

    public function test_validate_as_number_should_set_input_type_number_to_config()
    {
        $this->builder->validateAsNumber();

        /** @var InputFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals('number', $config->getInputType());
    }

    public function test_validate_as_phone_should_set_phone_rule_to_config()
    {
        $this->builder->validateAsPhone();

        /** @var InputFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals([ new Phone ], $config->getRules());
    }

    public function test_validate_as_phone_with_msg_should_set_phone_rule_with_msg_to_config()
    {
        $msg = 'Test message';

        $this->builder->validateAsPhone($msg);

        /** @var InputFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals([ $this->fieldName . '.Phone' => $msg ], $config->getErrorMessages());
    }

    public function test_greater_than_field_should_add_gt_rule_to_config()
    {
        $fieldName = 'other_field';

        $this->builder->greaterThanField($fieldName);

        /** @var InputFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals(["gt:$fieldName"], $config->getRules());
    }

    public function test_greater_than_with_msg_field_should_add_gt_rule_with_msg_to_config()
    {
        $msg = 'Some test msg';

        $this->builder->greaterThanField('other_field', $msg);

        /** @var InputFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals([$this->fieldName . '.gt' => $msg], $config->getErrorMessages());
    }

    public function test_lower_than_field_should_add_lt_rule_to_config()
    {
        $fieldName = 'other_field';

        $this->builder->lowerThanField($fieldName);

        /** @var InputFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals(["lt:$fieldName"], $config->getRules());
    }

    public function test_lower_than_with_msg_field_should_add_lt_rule_with_msg_to_config()
    {
        $msg = 'Some test msg';

        $this->builder->lowerThanField('other_field', $msg);

        /** @var InputFormControlConfig $config */
        $config = $this->builder->export();
        $this->assertEquals([$this->fieldName . '.lt' => $msg], $config->getErrorMessages());
    }
}