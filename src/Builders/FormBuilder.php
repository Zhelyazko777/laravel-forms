<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Utilities\Contracts\CanExport;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\FormConfig;

class FormBuilder implements CanExport
{
    private FormConfig $config;

    public function __construct()
    {
        $this->config = new FormConfig();
    }

    public function addAction(string $action): self
    {
        $this->config->setAction($action);

        return $this;
    }

    public function addInput(string $name, callable $callback): self
    {
        $builder = new InputControlBuilder($name);
        $callback($builder);
        $this->addControl($builder->export());

        return $this;
    }

    public function addSelect(string $name, callable $callback): self
    {
        $builder = new SelectControlBuilder($name);
        $callback($builder);
        $this->addControl($builder->export());

        return $this;
    }

    public function addMultiselect(string $name, callable $callback): self
    {
        $builder = new MultiselectControlBuilder($name);
        $callback($builder);
        $this->addControl($builder->export());

        return $this;
    }

    public function addSwitch(string $name, callable $callback): self
    {
        $builder = new SwitchControlBuilder($name);
        $callback($builder);
        $this->addControl($builder->export());

        return $this;
    }

    public function addTextarea(string $name, callable $callback): self
    {
        $builder = new TextareaControlBuilder($name);
        $callback($builder);
        $this->addControl($builder->export());

        return $this;
    }

    public function addGalleryUploader(string $name, callable $callback): self
    {
        $builder = new GalleryUploaderControlBuilder($name);
        $callback($builder);
        $this->addControl($builder->export());

        return $this;
    }

    public function addSubmitButton(callable $callback): self
    {
        $builder = new ButtonBuilder();
        $callback($builder);
        $this->config->setSubmitButton($builder->export());

        return $this;
    }

    public function export(): FormConfig
    {
        return $this->config;
    }

    private function addControl(BaseFormControlConfig $control): void
    {
        $this->config->setControls(array_merge(
            $this->config->getControls(),
            [ $control ]
        ));
    }
}
