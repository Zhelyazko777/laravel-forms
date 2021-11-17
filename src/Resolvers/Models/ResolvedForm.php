<?php

namespace Zhelyazko777\Forms\Resolvers\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\ButtonFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;

class ResolvedForm
{
    public function __construct(
        private FormConfig $config
    ) { }

    /** @var array<BaseResolvedFormControl|BaseFormControlConfig> */
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
     * @return static
     */
    public function setCallback(?string $callback): static
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
     * @param  array<BaseResolvedFormControl|BaseFormControlConfig>  $controls
     * @return ResolvedForm
     */
    public function setControls(array $controls): static
    {
        $this->controls = $controls;
        return $this;
    }

    /**
     * @return ButtonFormControlConfig|null
     */
    public function getSubmitButton(): ?ButtonFormControlConfig
    {
        return $this->submitButton;
    }

    /**
     * @param  ButtonFormControlConfig|null  $submitButton
     * @return $this
     */
    public function setSubmitButton(?ButtonFormControlConfig $submitButton): static
    {
        $this->submitButton = $submitButton;
        return $this;
    }

    /**
     * @return array
     */
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