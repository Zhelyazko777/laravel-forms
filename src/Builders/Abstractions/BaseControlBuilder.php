<?php

namespace Zhelyazko777\Forms\Builders\Abstractions;

use Zhelyazko777\Utilities\Contracts\CanExport;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use ReflectionClass;

abstract class BaseControlBuilder implements CanExport
{
    protected BaseFormControlConfig $config;

    public function __construct(string $name)
    {
        $this->config->setName($name);
    }

    public function takeColumns(int $numberOfColumns, int $numberOfColumnsOnMobile = 12): static
    {
        $this->config->setColumnsToTake($numberOfColumns);
        $this->config->setColumnsToTakeOnMobile($numberOfColumnsOnMobile);

        return $this;
    }

    public function makeHalfWidthOnDesktop(): static
    {
        $this->config->setColumnsToTake(6);

        return $this;
    }

    public function withLabel(string $label): static
    {
        $this->config->setLabel($label);
        return $this;
    }

    public function makeRequired(?string $message = null): static
    {
        $this->addValidationRule('required', $message);
        return $this;
    }

    public function disable(): static
    {
        $this->config->setDisabled(true);
        return $this;
    }

    public function addValidationRule(mixed $rule, ?string $message = null): static
    {
        if (!in_array($rule, $this->config->getRules())) {
            $fieldName = $this->config->getName();
            $this->config->setRules(array_merge($this->config->getRules(), [$rule]));

            if (!is_null($message)) {
                if (is_object($rule)) {
                    $rule = (new ReflectionClass($rule))->getShortName();
                }

                $this->config->setErrorMessages(array_merge($this->config->getErrorMessages(), [ "$fieldName.$rule" => $message, ]));
            }
        }

        return $this;
    }

    public function addSingleValidationRule(mixed $rule, ?string $message = null): static
    {
        if (!in_array($rule, $this->config->getSingleRules())) {
            $fieldName = $this->config->getName();
            $this->config->setSingleRules(array_merge($this->config->getSingleRules(), [$rule]));

            if (!is_null($message)) {
                if (is_object($rule)) {
                    $rule = (new ReflectionClass($rule))->getShortName();
                } else if (is_string($rule)) {
                    $rule = explode(':', $rule)[0];
                }

                $this->config->setErrorMessages(array_merge($this->config->getErrorMessages(), [ "$fieldName.*.$rule" => $message]));
            }
        }

        return $this;
    }

    public function export(): BaseFormControlConfig
    {
        return $this->config;
    }
}
