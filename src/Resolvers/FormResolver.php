<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\Contracts\NonResolvableControlInterface;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;
use Zhelyazko777\Forms\Models\FormData;
use Zhelyazko777\Forms\Resolvers\Contracts\FormResolverInterface;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Illuminate\Database\Eloquent\Model;

class FormResolver implements FormResolverInterface
{
    /** @var array<string, string> */
    private array $controlResolvers = [
        InputFormControlConfig::class => InputControlResolver::class,
        TextareaFormControlConfig::class => TextareaControlResolver::class,
        SelectFormControlConfig::class => SelectControlResolver::class,
        MultiselectFormControlConfig::class => MultiselectControlResolver::class,
    ];

    public function resolve(FormConfig $config, Model $model): FormData
    {
        $formData = new FormData($config);

        $formData->setControls($this->resolveControls($config->getControls(), $model));
        $formData->setSubmitButton($config->getSubmitButton());
        $formData->setAction($config->getAction());
        $formData->setCallback($config->getCallback());

        return $formData;
    }

    /**
     * @param  array<BaseFormControlConfig>  $controls
     * @param  Model  $model
     * @return array<BaseResolvedFormControl|BaseFormControlConfig>
     * @throws \Exception
     */
    private function resolveControls(array $controls, Model $model): array
    {
        $result = [];
        foreach ($controls as $control)
        {
            $controlClass = get_class($control);
            if (array_key_exists($controlClass, $this->controlResolvers)) {
                $resolver = new ($this->controlResolvers[$controlClass])();
                $result[] = $resolver->resolve($control, $model);
            } else if ($control instanceof NonResolvableControlInterface && $control instanceof \JsonSerializable) {
                $result[] = $control;
            } else {
                throw new \Exception('Form control type should be bind to Resolver class or should implement NonResolvableControlInterface and JsonSerializable');
            }
        }

        return $result;
    }
}
