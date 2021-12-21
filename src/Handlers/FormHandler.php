<?php

namespace Zhelyazko777\Forms\Handlers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SwitchFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;
use Zhelyazko777\Forms\Handlers\Abstractions\BaseControlHandler;
use Zhelyazko777\Forms\Handlers\Contracts\FormHandlerInterface;
use Illuminate\Database\Eloquent\Model;

class FormHandler implements FormHandlerInterface
{
    /**
     * @var array<string, string>
     */
    private array $handlers = [
        MultiselectFormControlConfig::class => BelongsToManyHandler::class,
        SelectFormControlConfig::class => NonRelationValueHandler::class,
        InputFormControlConfig::class => NonRelationValueHandler::class,
        TextareaFormControlConfig::class => NonRelationValueHandler::class,
        SwitchFormControlConfig::class => NonRelationValueHandler::class,
    ];

    /**
     * @param  FormConfig  $config
     * @param  Model  $model
     * @param  array<string, mixed> $requestData
     * @return void
     */
    public function handle(FormConfig $config, Model $model, array $requestData): void
    {
        $propertyNames = array_keys($requestData);
        \DB::beginTransaction();
        try {
            foreach ($propertyNames as $propName)
            {
                $value = $requestData[$propName];
                $controlArr = array_filter(
                    $config->getControls(),
                    fn (BaseFormControlConfig $c) => $c->getName() === $propName && !$c->getDisabled()
                );
                $controlConfig = array_pop($controlArr);

                /** @var BaseControlHandler $handler */
                $handler = new $this->handlers[get_class($controlConfig)]();
                $handler->handle($controlConfig, $model, $value);
            }

            $model->save();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception($e->getMessage(), 0, $e);
        }
    }
}
