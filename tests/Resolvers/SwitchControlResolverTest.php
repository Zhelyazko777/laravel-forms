<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Zhelyazko777\Forms\Builders\Models\SwitchFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSwitchFormControl;
use Zhelyazko777\Forms\Resolvers\SwitchControlResolver;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;
use Zhelyazko777\Forms\Tests\TestClasses\Toy;

class SwitchControlResolverTest extends TestCase
{
    private SwitchControlResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->resolver = new SwitchControlResolver;
    }

    public function test_resolve_should_populate_model_value()
    {
        $isTrained = true;
        $config = (new SwitchFormControlConfig)->setName('is_trained');
        $model = new Pet;
        $model->is_trained = $isTrained;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($isTrained, $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_given_default_value()
    {
        $isTrained = false;
        $config = (new SwitchFormControlConfig)->setName('is_trained')->setValue($isTrained);
        $model = new Pet;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($isTrained, $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_given_default_value_and_override_model_value()
    {
        $isTrained = false;
        $config = (new SwitchFormControlConfig)->setName('is_trained')->setValue($isTrained);
        $model = new Pet;
        $model->is_trained = true;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($isTrained, $resolvedControl->getValue());
    }

    public function test_resolve_should_return_resolved_switch_form_control()
    {
        $config = (new SwitchFormControlConfig)->setName('is_trained');
        $model = new Pet;

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals(ResolvedSwitchFormControl::class, get_class($resolvedControl));
    }

    public function test_resolve_with_nested_property_should_fetch_the_value_correctly()
    {
        $config = (new SwitchFormControlConfig)->setName('pet:is_trained');
        $model = Toy::find(2);

        $resolvedControl = $this->resolver->resolve($config, $model);

        $this->assertEquals($model->pet->is_trained, $resolvedControl->getValue());
    }
}