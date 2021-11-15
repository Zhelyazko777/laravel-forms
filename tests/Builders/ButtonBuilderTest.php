<?php

namespace Zhelyazko777\Forms\Tests\Builders;

use Zhelyazko777\Forms\Builders\ButtonBuilder;
use Zhelyazko777\Forms\Builders\Models\ButtonFormControlConfig;
use Zhelyazko777\Forms\Tests\TestCase;

class ButtonBuilderTest extends TestCase
{
    public function test_add_text_should_add_text_to_config()
    {
        $text = 'Test';
        $builder = new ButtonBuilder();

        $builder->addText($text);

        $this->assertEquals($text, $builder->export()->getText());
    }

    public function test_export_should_return_button_form_control_config()
    {
        $builder = new ButtonBuilder();

        $this->assertEquals(ButtonFormControlConfig::class, get_class($builder->export()));
    }
}