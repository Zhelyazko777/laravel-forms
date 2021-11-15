<?php

namespace Zhelyazko777\Forms\Tests\Builders;

use Zhelyazko777\Forms\Builders\ButtonBuilder;
use Zhelyazko777\Forms\Builders\FormBuilder;
use Zhelyazko777\Forms\Builders\GalleryUploaderControlBuilder;
use Zhelyazko777\Forms\Builders\InputControlBuilder;
use Zhelyazko777\Forms\Builders\Models\ButtonFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Builders\Models\GalleryUploaderFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SwitchFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;
use Zhelyazko777\Forms\Builders\MultiselectControlBuilder;
use Zhelyazko777\Forms\Builders\SelectControlBuilder;
use Zhelyazko777\Forms\Builders\SwitchControlBuilder;
use Zhelyazko777\Forms\Builders\TextareaControlBuilder;
use Zhelyazko777\Forms\Tests\TestCase;

class FormBuilderTest extends TestCase
{
    private FormBuilder $builder;

    protected function setUp(): void
    {
        $this->builder = new FormBuilder();
        parent::setUp();
    }

    public function test_add_action_should_set_action_to_the_config()
    {
        $action = '/some_action';

        $this->builder->addAction($action);

        $this->assertEquals($action, $this->builder->export()->getAction());
    }

    public function test_add_callback_should_add_callback_to_the_config()
    {
        $callback = 'testCallback';

        $this->builder->addCallback($callback);

        $this->assertEquals($callback, $this->builder->export()->getCallback());
    }

    public function test_add_input_should_add_input_to_the_config()
    {
        $input = 'test_input';

        $controls = $this
            ->builder
            ->addInput($input, fn (InputControlBuilder $b) => $b)
            ->export()
            ->getControls();

        $this->assertCount(1, $controls);
        $this->assertEquals($input, $controls[0]->getName());
        $this->assertEquals(InputFormControlConfig::class, get_class($controls[0]));
    }

    public function test_add_select_should_add_select_to_the_config()
    {
        $input = 'test_input';

        $controls = $this
            ->builder
            ->addSelect($input, fn (SelectControlBuilder $b) => $b)
            ->export()
            ->getControls();

        $this->assertCount(1, $controls);
        $this->assertEquals($input, $controls[0]->getName());
        $this->assertEquals(SelectFormControlConfig::class, get_class($controls[0]));
    }

    public function test_add_multiselect_should_add_multiselect_to_the_config()
    {
        $input = 'test_input';

        $controls = $this
            ->builder
            ->addMultiselect($input, fn (MultiselectControlBuilder $b) => $b)
            ->export()
            ->getControls();

        $this->assertCount(1, $controls);
        $this->assertEquals($input, $controls[0]->getName());
        $this->assertEquals(MultiselectFormControlConfig::class, get_class($controls[0]));
    }

    public function test_add_switch_should_add_switch_to_the_config()
    {
        $input = 'test_input';

        $controls = $this
            ->builder
            ->addSwitch($input, fn (SwitchControlBuilder $b) => $b)
            ->export()
            ->getControls();

        $this->assertCount(1, $controls);
        $this->assertEquals($input, $controls[0]->getName());
        $this->assertEquals(SwitchFormControlConfig::class, get_class($controls[0]));
    }

    public function test_add_textarea_should_add_textarea_to_the_config()
    {
        $input = 'test_input';

        $controls = $this
            ->builder
            ->addTextarea($input, fn (TextareaControlBuilder $b) => $b)
            ->export()
            ->getControls();

        $this->assertCount(1, $controls);
        $this->assertEquals($input, $controls[0]->getName());
        $this->assertEquals(TextareaFormControlConfig::class, get_class($controls[0]));
    }

    public function test_add_gallery_uploader_should_add_gallery_uploader_to_the_config()
    {
        $input = 'test_input';

        $controls = $this
            ->builder
            ->addGalleryUploader($input, fn (GalleryUploaderControlBuilder $b) => $b)
            ->export()
            ->getControls();

        $this->assertCount(1, $controls);
        $this->assertEquals($input, $controls[0]->getName());
        $this->assertEquals(GalleryUploaderFormControlConfig::class, get_class($controls[0]));
    }

    public function test_add_submit_btn_should_add_submit_btn_to_the_config()
    {
        $btn = $this
            ->builder
            ->addSubmitButton(fn (ButtonBuilder $b) => $b)
            ->export()
            ->getSubmitButton();

        $this->assertNotNull($btn);
        $this->assertEquals(ButtonFormControlConfig::class, get_class($btn));
    }

    public function test_export_should_return_form_config()
    {
        $this->assertEquals(FormConfig::class, get_class($this->builder->export()));
    }
}