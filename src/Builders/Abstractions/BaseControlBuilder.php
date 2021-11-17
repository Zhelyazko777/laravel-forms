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
        if (empty($name)) {
            throw new \InvalidArgumentException('You should pass name different from whitespace for all of the form fields.');
        }

        $this->config->setName($name);
    }

    /**
     * How much columns to take from the grid(1-12)
     * @param  int  $numberOfColumns
     * @param  int  $numberOfColumnsOnMobile
     * @return $this
     */
    public function takeColumns(int $numberOfColumns, int $numberOfColumnsOnMobile = 12): static
    {
        $this->config->setColumnsToTake($numberOfColumns);
        $this->config->setColumnsToTakeOnMobile($numberOfColumnsOnMobile);

        return $this;
    }

    /**
     * Makes the field half of the width of it's container
     * @return $this
     */
    public function makeHalfWidthOnDesktop(): static
    {
        $this->config->setColumnsToTake(6);

        return $this;
    }

    /**
     * Sets label for the field
     * @param  string  $label
     * @return $this
     */
    public function withLabel(string $label): static
    {
        $this->config->setLabel($label);
        return $this;
    }

    /**
     * Sets default value for the field
     * @param  mixed  $value
     * @return $this
     */
    public function withValue(mixed $value): static
    {
        $this->config->setValue($value);
        return $this;
    }

    /**
     * Makes field required
     * @param  string|null  $message
     * @return $this
     */
    public function makeRequired(?string $message = null): static
    {
        $this->addValidationRule('required', $message);
        return $this;
    }

    /**
     * Disables the field
     * @return $this
     */
    public function disable(): static
    {
        $this->config->setDisabled(true);
        return $this;
    }

    /**
     * Adds "hidden" attribute to the field
     * @return $this
     */
    public function hide(): static
    {
        $this->config->setHidden(true);
        return $this;
    }

    /**
     * Adds validation rule for the field
     * @param  mixed  $rule
     * @param  string|null  $message
     * @return $this
     * @throws \ReflectionException
     */
    public function addValidationRule(mixed $rule, ?string $message = null): static
    {
        if (!in_array($rule, $this->config->getRules())) {
            $fieldName = $this->config->getName();
            $this->config->setRules(array_merge($this->config->getRules(), [$rule]));

            if (!is_null($message)) {
                if (is_object($rule)) {
                    $rule = (new ReflectionClass($rule))->getShortName();
                } else if (is_string($rule)) {
                    $rule = explode(':', $rule)[0];
                }

                $this->config->setErrorMessages(
                    array_merge(
                        $this->config->getErrorMessages(),
                        [ "$fieldName.$rule" => $message, ]
                    )
                );
            }
        }

        return $this;
    }

    /**
     * Removes validation rule for the field
     * @param  mixed  $rule
     * @return $this
     * @throws \ReflectionException
     */
    public function removeValidationRule(mixed $rule): static
    {
        $fieldName = $this->config->getName();
        $this->config->setRules(
            array_filter(
                $this->config->getRules(),
                fn ($r) => $r !== $rule
            )
        );

        if (is_object($rule)) {
            $rule = (new ReflectionClass($rule))->getShortName();
        } else if (is_string($rule)) {
            $rule = explode(':', $rule)[0];
        }

        $this->config->setErrorMessages(
            array_filter(
                $this->config->getErrorMessages(),
                fn ($r) => $r !== "$fieldName.$rule",
                ARRAY_FILTER_USE_KEY
            )
        );

        return $this;
    }

    /**
     * Adds rule for request items of type array
     * which will be applied to every item of the array
     * @param  mixed  $rule
     * @param  string|null  $message
     * @return $this
     * @throws \ReflectionException
     */
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

                $this->config->setErrorMessages(
                    array_merge(
                        $this->config->getErrorMessages(),
                        [ "$fieldName.*.$rule" => $message]
                    )
                );
            }
        }

        return $this;
    }

    /**
     * Removes rule for request items of type array
     * which should be applied to every item of the array
     * @param  mixed  $rule
     * @return $this
     * @throws \ReflectionException
     */
    public function removeSingleValidationRule(mixed $rule): static
    {
        $fieldName = $this->config->getName();
        $this->config->setSingleRules(
            array_filter(
                $this->config->getSingleRules(),
                fn ($r) => $r !== $rule
            )
        );

        if (is_object($rule)) {
            $rule = (new ReflectionClass($rule))->getShortName();
        } else if (is_string($rule)) {
            $rule = explode(':', $rule)[0];
        }

        $this->config->setErrorMessages(
            array_filter(
                $this->config->getErrorMessages(),
                fn ($r) => $r !== "$fieldName.*.$rule",
                ARRAY_FILTER_USE_KEY
            ),
        );

        return $this;
    }

    /**
     * Exports the config object
     * @return BaseFormControlConfig
     */
    public function export(): BaseFormControlConfig
    {
        return $this->config;
    }
}
