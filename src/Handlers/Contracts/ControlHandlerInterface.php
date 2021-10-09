<?php

namespace Zhelyazko777\Forms\Handlers\Contracts;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Illuminate\Database\Eloquent\Model;

interface ControlHandlerInterface
{
    public function handle(BaseFormControlConfig $config, Model $model, string $propertyName, mixed $value): void;
}
