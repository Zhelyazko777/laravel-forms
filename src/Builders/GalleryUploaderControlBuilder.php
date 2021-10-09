<?php

namespace Zhelyazko777\Forms\Builders;

use Zhelyazko777\Forms\Builders\Abstractions\BaseControlBuilder;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Builders\Models\GalleryUploaderFormControlConfig;
use Illuminate\Validation\Rule;

class GalleryUploaderControlBuilder extends BaseControlBuilder
{
    /**
     * @var GalleryUploaderFormControlConfig
     */
    protected BaseFormControlConfig $config;

    public function __construct(string $name)
    {
        $this->config = new GalleryUploaderFormControlConfig();
        parent::__construct($name);
    }

    public function makeRequired(?string $message = null): static
    {
        $this->addSingleValidationRule('required');

        return parent::makeRequired();
    }

    public function addImageDimensions(int $minWidth, int $maxWidth, int $minHeight, int $maxHeight, ?string $message = null): self
    {
        $rule = ((string)Rule::dimensions()
            ->minWidth($minWidth)
            ->maxWidth($maxWidth)
            ->minHeight($minHeight)
            ->maxHeight($maxHeight));
        $this->addSingleValidationRule($rule, $message);

        return $this;
    }

    /**
     * @param  array<string>  $mimes
     * @return $this
     */
    public function addSupportedMimes(array $mimes, ?string $message = null): self
    {
        $mimesStr = implode(',', $mimes);
        $this->addSingleValidationRule("mimes:$mimesStr", $message);

        return $this;
    }

    public function addImageMaxFileSize(int $value, ?string $message = null): self
    {
        $this->addSingleValidationRule("max:$value", $message);

        return $this;
    }

    public function imageUploadRoute(string $route): self
    {
        $this->config->setUploadRoute($route);

        return $this;
    }

    public function imageRemoveRoute(string $route): self
    {
        $this->config->setRemoveImageRoute($route);

        return $this;
    }

    public function imagesLoadRoute(string $route): self
    {
        $this->config->setLoadImagesRoute($route);

        return $this;
    }
}
