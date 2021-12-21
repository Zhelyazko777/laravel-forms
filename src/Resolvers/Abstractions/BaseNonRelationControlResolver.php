<?php

namespace Zhelyazko777\Forms\Resolvers\Abstractions;

use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Resolvers\Contracts\ControlResolverInterface;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;

abstract class BaseNonRelationControlResolver implements ControlResolverInterface
{
    protected function populateValue(Model $model, BaseResolvedFormControl $formControl): BaseResolvedFormControl
    {
        if (is_null($formControl->getValue())) {
            $nameParts = explode(':', $formControl->getName());
            $value = $model;
            foreach ($nameParts as $part) {
                $value = $value->{$part};
            }
            $formControl->setValue($value);
        }

        return $formControl;
    }
}