<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Zhelyazko777\Forms\Resolvers\SelectControlResolver;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Owner;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

class SelectControlResolverTest extends TestCase
{
    private SelectControlResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDb();
        $this->resolver = new SelectControlResolver;
    }

    public function test_resolve_should_return_resolved_select_form_control_instance()
    {
        $config = (new SelectFormControlConfig)->setName('owners');

        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(ResolvedSelectFormControl::class, get_class($resolvedControl));
    }

    public function test_resolve_should_add_fixed_options_if_provided()
    {
        $config = (new SelectFormControlConfig)
            ->setName('owners')
            ->setFixedOptions([
            [
                'value' => 1,
                'text' => 'Option 1'
            ],
            [
                'value' => 2,
                'text' => 'Option 2'
            ],
        ]);

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals($config->getFixedOptions(), $resolvedControl->getOptions());
    }

    public function test_resolve_should_fetch_options_if_no_fixed_values_provided()
    {
        $config = (new SelectFormControlConfig)->setName('owners');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(
            Owner::query()->get([ 'name AS text', 'id AS value' ])->toArray(),
            $resolvedControl->getOptions()
        );
    }

    public function test_resolve_should_set_fixed_value_if_provided()
    {
        $config = (new SelectFormControlConfig)->setFixedOptions([
            [
                'value' => 1,
                'text' => 'Option 1'
            ],
            [
                'value' => 2,
                'text' => 'Option 2'
            ],
        ])->setValue(1);

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals($config->getValue(), $resolvedControl->getValue());
    }

    public function test_resolve_should_override_value_with_fixed_value_if_provided()
    {
        $config = (new SelectFormControlConfig)->setName('owners')->setValue(100);

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Pet::first());

        $this->assertEquals($config->getValue(), $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_value_if_not_provided()
    {
        $config = (new SelectFormControlConfig)->setName('owners');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Pet::query()->find(5));

        $this->assertEquals(3, $resolvedControl->getValue());
    }
}