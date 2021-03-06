<?php

namespace Zhelyazko777\Forms\Resolvers\Contracts;

use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Models\FormData;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedForm;

interface FormResolverInterface
{
    /**
     * @param  FormConfig  $config
     * @param  Model  $model
     * @return ResolvedForm
     */
    public function resolve(FormConfig $config, Model $model): ResolvedForm;
}
