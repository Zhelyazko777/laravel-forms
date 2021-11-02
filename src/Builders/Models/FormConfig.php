<?php

namespace Zhelyazko777\Forms\Builders\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\Contracts\ExcludeFromCommonRequestInterface;

class FormConfig
{
    /**
     * @var array<BaseFormControlConfig>
     */
    private array $controls = [];

    private ?ButtonFormControlConfig $submitButton = null;

    private string $action = '';

    private ?string $callback = null;

    /**
     * @return string|null
     */
    public function getCallback(): ?string
    {
        return $this->callback;
    }

    /**
     * @param  string|null  $callback
     * @return FormConfig
     */
    public function setCallback(?string $callback): FormConfig
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @return BaseFormControlConfig[]
     */
    public function getControls(): array
    {
        return $this->controls;
    }

    /**
     * @param  BaseFormControlConfig[]  $controls
     * @return FormConfig
     */
    public function setControls(array $controls): FormConfig
    {
        $this->controls = $controls;
        return $this;
    }

    /**
     * @return ?ButtonFormControlConfig
     */
    public function getSubmitButton(): ?ButtonFormControlConfig
    {
        return $this->submitButton;
    }

    /**
     * @param  ?ButtonFormControlConfig  $submitButton
     * @return FormConfig
     */
    public function setSubmitButton(?ButtonFormControlConfig $submitButton): FormConfig
    {
        $this->submitButton = $submitButton;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param  string  $action
     * @return FormConfig
     */
    public function setAction(string $action): FormConfig
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getRules(): array
    {
        $rules = [];

        foreach ($this->controls as $control)
        {
            if ($control->getDisabled() || $control instanceof ExcludeFromCommonRequestInterface) {
                continue;
            }

            $rules[$control->getName()] = $control->getRules();
            if (count($control->getSingleRules()) > 0) {
                $rules[$control->getName() . '.*'] = $control->getSingleRules();
            }
        }

        return $rules;
    }

    /**
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function getSingleFieldRules(string $fieldName): array
    {
        $rules = [];

        $control = array_filter($this->controls, fn ($x) => $x->getName() === $fieldName);
        if (count($control) === 0) {
            throw new \Exception('Wrong control name given!');
        }
        $control = reset($control);

        $rules[$control->getName()] = $control->getRules();
        $rules[$control->getName() . '.*'] = $control->getSingleRules();

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function getErrorMessages(): array
    {
        $messages = [];

        foreach ($this->controls as $control)
        {
            $messages = array_merge($control->getErrorMessages(), $messages);
        }

        return $messages;
    }


    /**
     * @param  string  $fieldName
     * @return array<string, string>
     * @throws \Exception
     */
    public function getSingleFieldErrorMessages(string $fieldName): array
    {
        $messages = [];

        /** @var BaseFormControlConfig[] $control */
        $control = array_filter($this->controls, fn ($c) => explode('.', $c->getName())[0] === $fieldName);
        if (count($control) === 0) {
            throw new \Exception('Wrong control name given!');
        }
        $control = array_pop($control);
        $messages = array_merge($control->getErrorMessages(), $messages);

        return $messages;
    }
}
