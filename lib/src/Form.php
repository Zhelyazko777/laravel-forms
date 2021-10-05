<?php

namespace Zhelyazko777\Forms;

use Zhelyazko777\Forms\Builders\FormBuilder;
use Zhelyazko777\Forms\Builders\Models\FormConfig;
use Zhelyazko777\Forms\Handlers\Contracts\FormHandlerInterface;
use Zhelyazko777\Forms\Models\FormData;
use Zhelyazko777\Forms\Resolvers\Contracts\FormResolverInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class Form
{
    /**
     * Creates form configuration ready to be passed the UI component
     * @param  string  $form
     * @param  Model  $model
     * @param  array<string, mixed>  $args
     * @return FormData
     */
    public function create(string $form, Model $model, array $args = []): FormData
    {
        $resolver = app()->get(FormResolverInterface::class);
        $formConfig = $this->getFormConfig($form, $model, $args);

        return $resolver->resolve($formConfig, $model);
    }

    /**
     * Handles form requests
     * @param  string  $form
     * @param  Model  $model
     * @param  FormRequest  $request
     * @param  array<string, mixed>  $args
     */
    public function handle(string $form, Model $model, FormRequest $request, array $args = []): void
    {
        $handler = app()->get(FormHandlerInterface::class);
        $formConfig = $this->getFormConfig($form, $model, $args);

        $handler->handle($formConfig, $model, $request->validated());
    }

    /**
     * Gets the validation rules for the form
     * @param  string  $form
     * @param  Model  $model
     * @param  array<string, mixed>  $args
     * @return array<string, mixed>
     */
    public function getValidationRules(string $form, Model $model, array $args = []): array
    {
        return $this->getFormConfig($form, $model, $args)->getRules();
    }

    /**
     * Gets the validation rules for some specific field
     * @param  string  $fieldName
     * @param  string  $form
     * @param  Model  $model
     * @param  array<string, mixed>  $args
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function getSingleFieldValidationRules(string $fieldName, string $form, Model $model, array $args = []): array
    {
        return $this->getFormConfig($form, $model, $args)->getSingleFieldRules($fieldName);
    }

    /**
     * Gets the overridden error messages for different fields
     * @param  string  $form
     * @param  Model  $model
     * @param  array<string, mixed>  $args
     * @return array<string, string>
     */
    public function getErrorMessages(string $form, Model $model, array $args = []): array
    {
        return $this->getFormConfig($form, $model, $args)->getErrorMessages();
    }

    /**
     * Gets the overridden error messages for single field
     * @param  string  $fieldName
     * @param  string  $form
     * @param  Model  $model
     * @param  array<string, mixed>  $args
     * @return array<string, string>
     * @throws \Exception
     */
    public function getSingleFieldErrorMessages(string $fieldName, string $form, Model $model, array $args = []): array
    {
        return $this->getFormConfig($form, $model, $args)->getSingleFieldErrorMessages($fieldName);
    }

    /**
     * @param  string  $form
     * @param  Model  $model
     * @param  array<string, mixed>  $args
     * @return FormConfig
     */
    private function getFormConfig(string $form, Model $model, array $args = []): FormConfig
    {
        $formInstance = new $form();
        $builder = new FormBuilder();
        $formInstance->build($builder, $model, $args);

        return $builder->export();
    }
}
