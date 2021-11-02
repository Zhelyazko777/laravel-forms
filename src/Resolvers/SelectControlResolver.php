<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseSelectFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class SelectControlResolver extends BaseControlResolver
{
    /**
     * @param  BaseSelectFormControlConfig  $control
     * @param  Model  $model
     * @return BaseResolvedFormControl
     */
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl
    {
        /** @var ResolvedSelectFormControl $controlToReturn */
        $controlToReturn = SimpleMapper::map($control, new ResolvedSelectFormControl());
        /** @var Builder $query */
        $query = $control->getOptionsQuery();
        $textProp = call_user_func($control->getModel().'::selectTextProperty');
        $valueProp = call_user_func($control->getModel().'::selectValueProperty');
        $controlToReturn->setOptions($query->get([ $valueProp . ' as value', $textProp . ' as text' ])->toArray());

        if (is_null($controlToReturn->getValue())) {
            $nameParts = explode(':', $control->getName());
            $value = $model;
            foreach ($nameParts as $part) {
                $value = $value->{$part};
            }
            $controlToReturn->setValue($value);
        }

        return $controlToReturn;
    }
}
