<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedInputFormControl;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class InputControlResolver extends BaseControlResolver
{
    public function resolve(BaseFormControlConfig $control, Model $model): ResolvedInputFormControl
    {
        /** @var ResolvedInputFormControl $controlToReturn */
        $controlToReturn = SimpleMapper::map($control, new ResolvedInputFormControl());

        $nameParts = explode(':', $control->getName());
        $value = $model;
        foreach ($nameParts as $part)
        {
            $value = $value->{$part};
        }
        $controlToReturn->setValue($value);

        return $controlToReturn;
    }
}
