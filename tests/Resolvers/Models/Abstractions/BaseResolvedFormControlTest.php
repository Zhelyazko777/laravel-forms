<?php

namespace Zhelyazko777\Forms\Tests\Resolvers\Models\Abstractions;

use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Rules\Phone;
use Zhelyazko777\Forms\Tests\TestCase;

abstract class BaseResolvedFormControlTest extends TestCase
{
    protected BaseResolvedFormControl $model;

    public function test_json_serialize_with_object_class_should_has_rule_short_class_name()
    {
        $this->model->setRules([new Phone]);

        $this->assertEquals(['Phone'], $this->model->jsonSerialize()['rules']);
    }
}