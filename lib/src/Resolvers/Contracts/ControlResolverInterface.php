<?php

namespace Zhelyazko777\Forms\Resolvers\Contracts;

use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Illuminate\Database\Eloquent\Model;

interface ControlResolverInterface
{
    /**
     * @param  array<string, mixed>  $config
     * @param  Model  $model
     * @return BaseResolvedFormControl
     */
    public function resolve(array $config, Model $model): BaseResolvedFormControl;
}
