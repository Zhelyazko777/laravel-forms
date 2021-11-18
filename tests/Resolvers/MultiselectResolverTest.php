<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedMultiselectFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Zhelyazko777\Forms\Resolvers\MultiselectControlResolver;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Home;
use Zhelyazko777\Forms\Tests\TestClasses\Owner;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

class MultiselectResolverTest extends TestCase
{
    private MultiselectControlResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpDb();
        $this->resolver = new MultiselectControlResolver();
    }

    public function test_resolve_should_return_resolved_multiselect_form_control_instance()
    {
        $config = (new MultiselectFormControlConfig())
            ->setOptionTextProperty('name')
            ->setName('owners');

        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(ResolvedMultiselectFormControl::class, get_class($resolvedControl));
    }

    public function test_resolve_should_add_fixed_options_if_provided()
    {
        $config = (new MultiselectFormControlConfig)->setFixedOptions([
            [
                'value' => 1,
                'text' => 'Option 1'
            ],
            [
                'value' => 2,
                'text' => 'Option 2'
            ],
        ])->setName('owners');

        /** @var ResolvedMultiselectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals($config->getFixedOptions(), $resolvedControl->getOptions());
    }

    public function test_resolve_should_fetch_options_if_options_query_provided()
    {
        $config = (new MultiselectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pets');

        /** @var ResolvedMultiselectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Owner);

        $this->assertEquals(
            Pet::query()->get([ 'name AS text', 'id AS value' ])->toArray(),
            $resolvedControl->getOptions()
        );
    }

    public function test_resolve_should_set_fixed_value_if_provided_on_fixed_options()
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
        ])->setName('owners')->setValue([1, 2]);

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals($config->getValue(), $resolvedControl->getValue());
    }

    public function test_resolve_should_override_value_with_fixed_value_if_provided_on_options_query()
    {
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('owners')
            ->setValue([1, 2]);

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals($config->getValue(), $resolvedControl->getValue());
    }

    public function test_resolve_should_fetch_value_for_the_field_if_no_value_provided()
    {
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pets');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Owner::first());

        $mappedPets = Owner::first()
            ->pets()
            ->pluck('pets.id')
            ->toArray();
        $this->assertEquals($mappedPets, $resolvedControl->getValue());
    }

    public function test_resolve_with_fixed_options_should_fetch_value_for_the_field_if_no_value_provided()
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
            [
                'value' => 3,
                'text' => 'Option 3'
            ],
        ])->setName('pets');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Owner::first());

        $this->assertEquals([1, 2, 3], $resolvedControl->getValue());
    }

    public function test_resolve_should_throw_exception_if_nested_property_given_for_name()
    {
        $this->expectExceptionMessage('We support only one level pivot table connections, yet.');
        $config = (new MultiselectFormControlConfig)->setName('owners.pets');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Home::find(1));
    }

    public function test_resolve_without_option_text_property_in_config_should_throw_an_exception()
    {
        $optionsModel = Owner::class;
        $this->expectExceptionMessage("You should add a text property for the $optionsModel options");

        $config = (new MultiselectFormControlConfig)->setName('owners');

        $this->resolver->resolve($config, Pet::find(2));
    }

    public function test_resolve_can_override_default_option_value_property_in_config()
    {
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setOptionValueProperty('name')
            ->setName('owners');

        /** @var ResolvedMultiselectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(
            Owner::query()->get([ 'name AS text', 'name AS value' ])->toArray(),
            $resolvedControl->getOptions()
        );
    }
}