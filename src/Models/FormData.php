<?php

namespace Zhelyazko777\Forms\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\ButtonFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;

class FormData implements \JsonSerializable
{
    private FormConfig $config;

    public function __construct(FormConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @var array<BaseResolvedFormControl|BaseFormControlConfig>
     */
    private array $controls = [];

    private ?ButtonFormControlConfig $submitButton = null;

    private string $action = '';

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return array<BaseResolvedFormControl|BaseFormControlConfig>
     */
    public function getControls(): array
    {
        return $this->controls;
    }

    /**
     * @param array<BaseResolvedFormControl|BaseFormControlConfig> $controls
     */
    public function setControls(array $controls): void
    {
        $this->controls = $controls;
    }

    public function getSubmitButton(): ?ButtonFormControlConfig
    {
        return $this->submitButton;
    }

    public function setSubmitButton(?ButtonFormControlConfig $submitButton): void
    {
        $this->submitButton = $submitButton;
    }

    /**
     * @return array<string, array<object|string>>
     */
    private function getValidationRules(): array
    {
        $rules = [];
        foreach ($this->getControls() as $control)
        {
            $rules[$control->getName()] = $control->getRules();
        }

        return $rules;
    }

    public function jsonSerialize()
    {
        return [
            'action' => $this->getAction(),
            'controls' => $this->getControls(),
            'submitButton' => $this->getSubmitButton(),
            'rules' => $this->getValidationRules(),
        ];
    }
}
