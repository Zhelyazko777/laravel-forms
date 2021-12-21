<?php

namespace Zhelyazko777\Forms\Tests\Resolvers;

use Illuminate\Database\Eloquent\Builder;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Zhelyazko777\Forms\Resolvers\SelectControlResolver;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;
use Zhelyazko777\Forms\Tests\TestClasses\PetType;
use Zhelyazko777\Forms\Tests\TestClasses\Toy;

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
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pet_type_id');

        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(ResolvedSelectFormControl::class, get_class($resolvedControl));
    }

    public function test_resolve_should_add_fixed_options_if_provided()
    {
        $config = (new SelectFormControlConfig)
            ->setName('pet_type_id')
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
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pet_type_id');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(
            PetType::query()->get([ 'name AS text', 'id AS value' ])->toArray(),
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
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pet_type_id')
            ->setValue(100);

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Pet::first());

        $this->assertEquals($config->getValue(), $resolvedControl->getValue());
    }

    public function test_resolve_should_populate_value_if_not_provided()
    {
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pet_type_id');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Pet::query()->find(5));

        $this->assertEquals(2, $resolvedControl->getValue());
    }

    public function test_resolve_with_fixed_options_should_populate_value_if_not_provided()
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
        ])->setName('pet_type_id');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Pet::query()->find(5));

        $this->assertEquals(2, $resolvedControl->getValue());
    }

    public function test_resolve_should_fetch_value_if_property_is_nested()
    {
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setName('pet:pet_type_id');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, Toy::find(2));

        $this->assertEquals(3, $resolvedControl->getValue());
    }

    public function test_resolve_without_option_text_property_in_config_should_throw_an_exception()
    {
        $optionsModel = PetType::class;
        $this->expectExceptionMessage("You should add a text property for the $optionsModel options");

        $config = (new SelectFormControlConfig)->setName('pet:pet_type_id');

        $this->resolver->resolve($config, Toy::find(2));
    }

    public function test_resolve_can_override_default_option_value_property_in_config()
    {
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setOptionValueProperty('name')
            ->setName('pet_type_id');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(
            PetType::query()->get([ 'name AS text', 'name AS value' ])->toArray(),
            $resolvedControl->getOptions()
        );
    }

    public function test_resolve_should_apply_query_builder_to_options_query()
    {
        $config = (new SelectFormControlConfig)
            ->setOptionTextProperty('name')
            ->setGetOptionsQuery(
                \Closure::fromCallable(
                    fn (Builder $query) => $query->where('name', '!=', 'Dog')
                )
            )
            ->setName('pet_type_id');

        /** @var ResolvedSelectFormControl $resolvedControl */
        $resolvedControl = $this->resolver->resolve($config, new Pet);

        $this->assertEquals(
            PetType::where('name', '!=', 'Dog')->get([ 'name AS text', 'id AS value' ])->toArray(),
            $resolvedControl->getOptions()
        );
    }
}