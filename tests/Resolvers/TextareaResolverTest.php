<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedTextareaFormControl;
use Zhelyazko777\Forms\Resolvers\TextareaControlResolver;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

class TextareaResolverTest extends TestCase
{
    private TextareaControlResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new TextareaControlResolver;
    }

    public function test_resolve_should_populate_model_value()
    {
        $name = 'Test name';
        $config = (new TextareaFormControlConfig)->setName('name');
        $model = new Pet;
        $model->name = $name;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($name, $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_given_default_value()
    {
        $name = 'Test name';
        $config = (new TextareaFormControlConfig)->setName('name')->setValue($name);
        $model = new Pet;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($name, $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_given_default_value_and_override_model_value()
    {
        $name = 'Test name';
        $config = (new TextareaFormControlConfig)->setName('name')->setValue($name);
        $model = new Pet;
        $model->name = 'Some diff value';

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($name, $resolvedControl->getValue());
    }

    public function test_resolve_should_return_resolved_textarea_form_control()
    {
        $config = (new TextareaFormControlConfig)->setName('name');
        $model = new Pet;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals(ResolvedTextareaFormControl::class, get_class($resolvedControl));
    }

}