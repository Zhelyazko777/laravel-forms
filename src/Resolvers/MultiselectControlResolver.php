<?php

namespace Zhelyazko777\Forms\Resolvers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseSelectControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedMultiselectFormControl;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class MultiselectControlResolver extends BaseSelectControlResolver
{
    /**
     * @param  MultiselectFormControlConfig  $control
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
        $relation = $this->getRelation($control->getName(), $model);

        if (empty($fixedOptions)) {
            $optionsModel = get_class($relation->getModel());
            $textProp = $control->getOptionTextProperty();
            $valueProp = $control->getOptionValueProperty();

            if (empty($textProp)) {
                throw new \Exception("You should add a text property for the $optionsModel options");
            }

            $query = call_user_func("$optionsModel::query");

            if (!is_null($getOptionsQuery)) {
                $query = $getOptionsQuery->call($this, $query);
            }
            $controlToReturn->setOptions($this->getQuerySelectOptions($query, $textProp, $valueProp));
        } else {
            $controlToReturn->setOptions($this->getFixedSelectOptions($fixedOptions));
        }

        if (is_null($controlToReturn->getValue())) {
            $controlToReturn->setValue($this->fetchFieldValue($relation, $valueProp ?? 'id'));
        }

        return $controlToReturn;
    }

    private function getRelation(string $controlName, Model $model): Relation
    {
        if (str_contains($controlName, '.')) {
            throw new \Exception('We support only one level pivot table connections, yet.');
        }

        return $model->{$controlName}();
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
