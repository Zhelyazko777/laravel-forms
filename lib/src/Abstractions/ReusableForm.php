<?php


namespace Zhelyazko777\Forms\Abstractions;

use Zhelyazko777\Forms\Builders\FormBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class ReusableForm
{
    /**
     * @param  FormBuilder  $builder
     * @param  Model  $model
     * @param  array<string, mixed>  $args
     */
    abstract public function build(FormBuilder $builder, Model $model, array $args = []): void;
}
