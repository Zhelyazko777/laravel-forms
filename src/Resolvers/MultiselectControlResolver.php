<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedMultiselectFormControl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class MultiselectControlResolver extends BaseControlResolver
{
    /**
     * @param  MultiselectFormControlConfig  $control
     * @param  Model  $model
     * @return BaseResolvedFormControl
     */
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl
    {
        /** @var ResolvedMultiselectFormControl $controlToReturn */
        $controlToReturn = SimpleMapper::map($control, new ResolvedMultiselectFormControl());
        /** @var Builder $query */
        $query = $control->getOptionsQuery();
        $textProp = call_user_func($control->getModel().'::selectTextProperty');
        $valueProp = call_user_func($control->getModel().'::selectValueProperty');
        $controlToReturn->setOptions($query->get([ $valueProp . ' as value', $textProp . ' as text' ])->toArray());

        $nameParts = explode(':', $control->getName());
        $value = $model;
        foreach ($nameParts as $part)
        {
            $value = $value->{$part};
        }
        $controlToReturn->setValue($this->mapValuesToSelectOptions($value->toArray(), $textProp, $valueProp));

        return $controlToReturn;
    }

    /**
     * @param  array<string, mixed>  $optionsData
     * @param  string  $textPropName
     * @param  string  $valuePropName
     * @return array<int, array<string, int|string>>
     */
    private function mapValuesToSelectOptions(array $optionsData, string $textPropName, string $valuePropName): array
    {
        $result = [];
        foreach ($optionsData as $optionData)
        {
            $result[] = [
                'value' => $optionData[$valuePropName],
                'text' => $optionData[$textPropName],
            ];
        }

        return $result;
    }
}
