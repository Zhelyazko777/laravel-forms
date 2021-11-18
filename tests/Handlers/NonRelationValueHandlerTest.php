<?php

namespace Zhelyazko777\Forms\Tests\Handlers;

use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Handlers\NonRelationValueHandler;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Pet;

class NonRelationValueHandlerTest extends TestCase
{
    private NonRelationValueHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new NonRelationValueHandler;
        $this->setUpDb();
    }

    public function test_handle_should_save_nested_value()
    {
        $value = 'Some value';
        $model = Pet::find(2);
        $inputConfig = (new InputFormControlConfig)->setName('toy.name');

        $this->handler->handle($inputConfig, $model, 'toy.name', $value);

        $this->assertEquals($value, $model->fresh()->toy->name);
    }
}