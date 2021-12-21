<?php

namespace Zhelyazko777\Forms\Resolvers;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseSelectControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class SelectControlResolver extends BaseSelectControlResolver
{
    /**
     * @param  SelectFormControlConfig  $control
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
            $modelNamespace = $this->getModelNamespace($model);
            $optionsModel = $this->getOptionsModel($control->getName(), $modelNamespace);
            $textProp = $control->getOptionTextProperty();
            $valueProp = $control->getOptionValueProperty();

            if (empty($textProp)) {
                throw new \Exception("You should add a text property for the $optionsModel options");
            }

            $query = call_user_func("$optionsModel::query");
            if (!is_null($getOptionsQuery)) {
                $getOptionsQuery->call($this, $query);
            }
            $controlToReturn->setOptions($this->getQuerySelectOptions($query, $textProp, $valueProp));
        } else {
            $controlToReturn->setOptions($this->getFixedSelectOptions($fixedOptions));
        }

        if (is_null($controlToReturn->getValue())) {
            $controlToReturn->setValue($this->fetchValue($control->getName(), $model));
        }

        return $controlToReturn;
    }

    private function getModelNamespace(Model $model): string
    {
        $modelName = get_class($model);
        return substr($modelName, 0, strrpos($modelName, '\\'));
    }

    private function getOptionsModel(string $propertyName, string $namespace): string
    {
        $propertyParts = explode(':', $propertyName);
        $property = end($propertyParts);
        $tableName = str_replace('_id', '', $property);
        $dbModelName = Str::studly(Str::singular($tableName));

        return "$namespace\\$dbModelName";
    }

    private function fetchValue(string $controlName, Model $model): mixed
    {
        $nameParts = explode(':', $controlName);
        $value = $model;
        foreach ($nameParts as $part) {
            $value = $value->{$part};
        }

        return $value;
    }
}
