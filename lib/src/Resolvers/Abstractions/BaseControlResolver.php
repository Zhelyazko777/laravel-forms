<?php

namespace Zhelyazko777\Forms\Resolvers\Abstractions;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Illuminate\Database\Eloquent\Model;

abstract class BaseControlResolver
{
    abstract public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl;
}
