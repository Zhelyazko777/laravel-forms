<?php

namespace Zhelyazko777\Forms\Resolvers;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseSelectControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
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
        $fixedOptions = $control->getFixedOptions();
        $getOptionsQuery = $control->getGetOptionsQuery();

        if (empty($fixedOptions)) {
            $relation = $this->getRelation($control->getName(), $model);
            $optionsModel = get_class($relation->getModel());
            $textProp = call_user_func($optionsModel.'::selectTextProperty');
            $valueProp = call_user_func($optionsModel.'::selectValueProperty');
            $query = call_user_func("$optionsModel::query");
            $relationColumnName = $relation->getRelationName();

            if (!is_null($getOptionsQuery)) {
                $query = $getOptionsQuery->call($this, [ $query ]);
            }
            $controlToReturn->setOptions($this->getQuerySelectOptions($query, $textProp, $valueProp));

            if (is_null($controlToReturn->getValue())) {
                $controlToReturn->setValue(
                    $relation
                        ->first(["$relationColumnName.$valueProp"])
                        ?->{$valueProp}
                );
            }
        } else {
            $controlToReturn->setOptions($this->getFixedSelectOptions($fixedOptions));
        }

        return $controlToReturn;
    }

    private function getRelation(string $controlName, Model $model): BelongsToMany
    {
        $nameParts = explode(':', $controlName);
        $value = $model;
        foreach ($nameParts as $part) {
            /** @var BelongsToMany $value */
            $value = $value->{$part}();
        }

        return $value;
    }
}
