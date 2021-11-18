<?php

namespace Zhelyazko777\Forms\Tests\Handlers;

use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Handlers\FormHandler;
use Zhelyazko777\Forms\Tests\TestCase;
use Zhelyazko777\Forms\Tests\TestClasses\Toy;

class FormHandlerTest extends TestCase
{
    private FormHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new FormHandler;
    }

    public function test_handle_should_save_value()
    {
        $value = 'Some value';
        $formConfig = (new FormConfig)
            ->setControls([
                (new InputFormControlConfig)->setName('name'),
            ]);

        $this->handler->handle($formConfig, new Toy, [ 'name' => $value ]);

        $createdModel = Toy::find(6);
        $this->assertNotNull($createdModel);
        $this->assertEquals($value, $createdModel->name);
    }
}