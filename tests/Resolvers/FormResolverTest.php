<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Zhelyazko777\Forms\Builders\Models\ButtonFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Builders\Models\GalleryUploaderFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SwitchFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;
use Zhelyazko777\Forms\Resolvers\FormResolver;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedGalleryUploaderFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedInputFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedMultiselectFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSwitchFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedTextareaFormControl;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

class FormResolverTest extends TestCase
{
    private FormResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new FormResolver;
        $this->setUpDb();
    }

    public function test_resolve_should_set_submit_button_if_provided()
    {
        $buttonConfig = (new ButtonFormControlConfig)->setText('text');
        $formConfig = (new FormConfig)->setSubmitButton($buttonConfig);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals($buttonConfig->getText(), $resolvedForm->getSubmitButton()->getText());
    }

    public function test_resolve_should_set_action_if_provided()
    {
        $action = '/test';
        $formConfig = (new FormConfig)->setAction($action);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals($action, $resolvedForm->getAction());
    }

    public function test_resolve_should_set_callback_if_provided()
    {
        $callback = 'onTest';
        $formConfig = (new FormConfig)->setCallback($callback);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals($callback, $resolvedForm->getCallback());
    }

    public function test_resolve_should_set_input_control_if_provided()
    {
        $controlConfig = (new InputFormControlConfig)->setName('name');
        $formConfig = (new FormConfig)->setControls([$controlConfig]);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals(
            ResolvedInputFormControl::class,
            get_class(current($resolvedForm->getControls()))
        );
    }

    public function test_resolve_should_set_switch_control_if_provided()
    {
        $controlConfig = (new SwitchFormControlConfig)->setName('is_trained');
        $formConfig = (new FormConfig)->setControls([$controlConfig]);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals(
            ResolvedSwitchFormControl::class,
            get_class(current($resolvedForm->getControls()))
        );
    }

    public function test_resolve_should_set_textarea_control_if_provided()
    {
        $controlConfig = (new TextareaFormControlConfig)->setName('name');
        $formConfig = (new FormConfig)->setControls([$controlConfig]);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals(
            ResolvedTextareaFormControl::class,
            get_class(current($resolvedForm->getControls()))
        );
    }

    public function test_resolve_should_set_select_control_if_provided()
    {
        $controlConfig = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pet_type_id');
        $formConfig = (new FormConfig)->setControls([$controlConfig]);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals(
            ResolvedSelectFormControl::class,
            get_class(current($resolvedForm->getControls()))
        );
    }

    public function test_resolve_should_set_multiselect_control_if_provided()
    {
        $controlConfig = (new MultiselectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('owners');
        $formConfig = (new FormConfig)->setControls([$controlConfig]);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals(
            ResolvedMultiselectFormControl::class,
            get_class(current($resolvedForm->getControls()))
        );
    }

    public function test_resolve_should_set_gallery_uploader_control_if_provided()
    {
        $controlConfig = (new GalleryUploaderFormControlConfig);
        $formConfig = (new FormConfig)->setControls([$controlConfig]);

        $resolvedForm = $this->resolver->resolve($formConfig, new Pet);

        $this->assertEquals(
            ResolvedGalleryUploaderFormControl::class,
            get_class(current($resolvedForm->getControls()))
        );
    }
}