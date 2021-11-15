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
     * @return FormData
     */
    public function setCallback(?string $callback): FormData
    {
        $this->callback = $callback;
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

    public function jsonSerialize()
    {
        return [
            'action' => $this->getAction(),
            'callback' => $this->getCallback(),
            'controls' => $this->getControls(),
            'submitButton' => $this->getSubmitButton(),
        ];
    }
}
