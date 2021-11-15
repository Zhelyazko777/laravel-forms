<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseSelectControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class SelectControlResolver extends BaseSelectControlResolver
{
    /**
     * @param  BaseFormControlConfig  $control
     * @param  Model  $model
     * @return BaseResolvedFormControl
     * @throws \Exception
     */
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl
    {
        /** @var ResolvedSelectFormControl $controlToReturn */
        $controlToReturn = SimpleMapper::map($control, new ResolvedSelectFormControl());
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
                $controlToReturn->setValue($this->fetchFieldValue($control, $model));
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
     * @return array<mixed>
     */
    private function fetchFieldValue(BaseFormControlConfig $control, Model $model): array
    {
        $nameParts = explode(':', $control->getName());
        $value = $model;
        foreach ($nameParts as $part) {
            $value = $value->{$part};
        }

        return $value;
    }
}
