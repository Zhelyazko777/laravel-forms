<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Abstractions\BaseTextControlResolver;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedTextareaFormControl;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class TextareaControlResolver extends BaseTextControlResolver
{
    public function resolve(BaseFormControlConfig $control, Model $model): ResolvedTextareaFormControl
    {
        /** @var ResolvedTextareaFormControl $controlToReturn */
        $controlToReturn = SimpleMapper::map($control, new ResolvedTextareaFormControl());
        $this->populateValue($model, $controlToReturn);
        return $controlToReturn;
    }
}
