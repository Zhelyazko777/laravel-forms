<?php

namespace Zhelyazko777\Forms\Resolvers;

use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseNonRelationControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedSwitchFormControl;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class SwitchControlResolver extends BaseNonRelationControlResolver
{
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl
    {
        /** @var ResolvedSwitchFormControl $controlToReturn */
        $controlToReturn = SimpleMapper::map($control, new ResolvedSwitchFormControl);
        $this->populateValue($model, $controlToReturn);
        return $controlToReturn;
    }
}
