<?php

namespace Zhelyazko777\Forms\Resolvers\Contracts;

use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Models\FormData;
use Illuminate\Database\Eloquent\Model;

interface FormResolverInterface
{
    public function resolve(FormConfig $config, Model $model): FormData;
}
