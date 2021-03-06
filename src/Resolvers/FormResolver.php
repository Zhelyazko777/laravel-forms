<?php

namespace Zhelyazko777\Forms\Resolvers;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Builders\Models\GalleryUploaderFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\InputFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\MultiselectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SelectFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\SwitchFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\TextareaFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Contracts\FormResolverInterface;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedForm;

class FormResolver implements FormResolverInterface
{
    /** @var array<string, string> */
    private array $controlResolvers = [
        InputFormControlConfig::class => InputControlResolver::class,
        TextareaFormControlConfig::class => TextareaControlResolver::class,
        SelectFormControlConfig::class => SelectControlResolver::class,
        MultiselectFormControlConfig::class => MultiselectControlResolver::class,
        SwitchFormControlConfig::class => SwitchControlResolver::class,
        GalleryUploaderFormControlConfig::class => GalleryUploaderResolver::class,
    ];

    public function resolve(FormConfig $config, Model $model): ResolvedForm
    {
        $resolvedForm = new ResolvedForm($config);

        $resolvedForm->setControls($this->resolveControls($config->getControls(), $model));
        $resolvedForm->setSubmitButton($config->getSubmitButton());
        $resolvedForm->setAction($config->getAction());
        $resolvedForm->setCallback($config->getCallback());

        return $resolvedForm;
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
            if (!array_key_exists($controlClass, $this->controlResolvers)) {
                throw new \Exception('Form control type should be bind to Resolver class.');
            }

            $resolver = new ($this->controlResolvers[$controlClass])();
            $result[] = $resolver->resolve($control, $model);
        }

        return $result;
    }
}
