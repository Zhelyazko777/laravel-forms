<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseSelectControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedMultiselectFormControl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class MultiselectControlResolver extends BaseSelectControlResolver
{
    /**
     * @param  BaseFormControlConfig  $control
     * @param  Model  $model
     * @return BaseResolvedFormControl
     * @throws \Exception
     */
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl
    {
        /** @var ResolvedMultiselectFormControl $controlToReturn */
        $controlToReturn = SimpleMapper::map($control, new ResolvedMultiselectFormControl());
        /** @var Builder $query */
        $query = $control->getOptionsQuery();
        $fixedOptions = $control->getFixedOptions();
        $hasFixedOptions = !empty($fixedOptions);
        $hasQuery = !is_null($query);

        if (!$hasFixedOptions && !$hasQuery) {
            throw new \Exception('You should set fixed options or add a model in order to fetch the select options.');
        }

        if (!$hasFixedOptions && $hasQuery) {
            $optionsModel = $query->getModel();
            $textProp = call_user_func($optionsModel.'::selectTextProperty');
            $valueProp = call_user_func($optionsModel.'::selectValueProperty');
            if (is_null($controlToReturn->getValue())) {
                $controlToReturn->setValue($this->fetchFieldValue($control, $model, $textProp, $valueProp));
            }

            $controlToReturn->setOptions($this->getQuerySelectOptions($query, $textProp, $valueProp));
        } else {
            $controlToReturn->setOptions($this->getFixedSelectOptions($fixedOptions));
        }

        return $controlToReturn;
    }

    /**
     * @param  BaseFormControlConfig  $control
     * @param  Model  $model
     * @param  string  $textProp
     * @param  string  $valueProp
     * @return array<mixed>
     */
    private function fetchFieldValue(BaseFormControlConfig $control, Model $model, string $textProp, string $valueProp): array
    {
        $nameParts = explode(':', $control->getName());
        $value = $model;
        foreach ($nameParts as $part) {
            $value = $value->{$part};
        }

        return $this->mapValuesToSelectOptions($value->toArray(), $textProp, $valueProp);
    }

    /**
     * @param  array<string, mixed>  $optionsData
     * @param  string  $textPropName
     * @param  string  $valuePropName
     * @return array<mixed>
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
