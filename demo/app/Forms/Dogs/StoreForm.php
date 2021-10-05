<?php

namespace App\Forms\Dogs;

use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Abstractions\ReusableForm;
use Zhelyazko777\Forms\Builders\FormBuilder;
use Zhelyazko777\Forms\Builders\InputControlBuilder;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class StoreForm extends ReusableForm
{
    public function build(FormBuilder $builder, Model $model, array $args = []): void
    {
        $builder
            ->addAction('')
            ->addInput('name', function (InputControlBuilder $input) {
                $input
                    ->withLabel('name')
                    ->minLength(5)
                    ->maxLength(50);
            });
    }
}
