<?php

namespace Zhelyazko777\Forms\Resolvers\Contracts;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Illuminate\Database\Eloquent\Model;

interface ControlResolverInterface
{
    /**
     * @param  BaseFormControlConfig  $control
     * @param  Model  $model
     * @return BaseResolvedFormControl
     */
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl;
}
