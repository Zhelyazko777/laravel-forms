<?php

namespace Zhelyazko777\Forms\Resolvers;

use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Contracts\ControlResolverInterface;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;

class SwitchControlResolver implements ControlResolverInterface
{
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl
    {

    }
}
