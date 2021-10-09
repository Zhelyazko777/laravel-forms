<?php

namespace Zhelyazko777\Forms\Handlers\Contracts;

use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Illuminate\Database\Eloquent\Model;

interface FormHandlerInterface
{
    /**
     * @param  FormConfig  $config
     * @param  Model  $model
     * @param  array<string, mixed>  $requestData
     */
    public function handle(FormConfig $config, Model $model, array $requestData): void;
}
