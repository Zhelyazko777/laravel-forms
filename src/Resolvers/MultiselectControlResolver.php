<?php

namespace Zhelyazko777\Forms\Resolvers;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseSelectControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedMultiselectFormControl;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Tests\TestClasses\Owner;
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
        $controlToReturn = SimpleMapper::map($control, new ResolvedMultiselectFormControl);
        $fixedOptions = $control->getFixedOptions();
        $getOptionsQuery = $control->getGetOptionsQuery();

        if (empty($fixedOptions)) {
            $relation = $this->getRelation($control->getName(), $model);
            $optionsModel = get_class($relation->getModel());
            $textProp = call_user_func($optionsModel.'::selectTextProperty');
            $valueProp = call_user_func($optionsModel.'::selectValueProperty');
            $query = call_user_func("$optionsModel::query");

            if (!is_null($getOptionsQuery)) {
                $query = $getOptionsQuery->call($this, [ $query ]);
            }
            $controlToReturn->setOptions($this->getQuerySelectOptions($query, $textProp, $valueProp));

            if (is_null($controlToReturn->getValue())) {
                $controlToReturn->setValue($this->fetchFieldValue($relation, $valueProp));
            }
        } else {
            $controlToReturn->setOptions($this->getFixedSelectOptions($fixedOptions));
        }

        return $controlToReturn;
    }

    private function getRelation(string $controlName, Model $model): Relation
    {
        $nameParts = explode(':', $controlName);
        $value = $model;
        foreach ($nameParts as $part) {
            $value = $value->{$part}();
        }

        return $value;
    }

    /**
     * @param  Relation  $relation
     * @param  string  $valueProp
     * @return array<mixed>
     */
    private function fetchFieldValue(Relation $relation, string $valueProp): array
    {
        $relationColumnName = $relation->getRelationName();
        return $relation
            ->pluck("$relationColumnName.$valueProp")
            ->toArray();
    }
}
