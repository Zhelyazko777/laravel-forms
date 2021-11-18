<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Resolvers\InputControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedInputFormControl;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;
use Zhelyazko777\Forms\Tests\TestClasses\Toy;

class InputControlResolverTest extends TestCase
{
    private InputControlResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new InputControlResolver;
    }

    public function test_resolve_should_populate_model_value()
    {
        $name = 'Test name';
        $config = (new InputFormControlConfig)->setName('name');
        $model = new Pet;
        $model->name = $name;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($name, $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_given_default_value()
    {
        $name = 'Test name';
        $config = (new InputFormControlConfig)->setName('name')->setValue($name);
        $model = new Pet;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($name, $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_given_default_value_and_override_model_value()
    {
        $name = 'Test name';
        $config = (new InputFormControlConfig)->setName('name')->setValue($name);
        $model = new Pet;
        $model->name = 'Some diff value';

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($name, $resolvedControl->getValue());
    }

    public function test_resolve_should_return_resolved_input_form_control()
    {
        $config = (new InputFormControlConfig)->setName('name');
        $model = new Pet;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals(ResolvedInputFormControl::class, get_class($resolvedControl));
    }

    public function test_resolve_with_nested_property_should_fetch_the_value_correctly()
    {
        $config = (new InputFormControlConfig)->setName('pet.name');
        $model = Toy::find(2);

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($model->pet->name, $resolvedControl->getValue());
    }
}