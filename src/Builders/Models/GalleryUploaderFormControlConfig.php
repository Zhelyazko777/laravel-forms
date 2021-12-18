<?php

namespace Zhelyazko777\Forms\Builders\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Utilities\Exportable;

class GalleryUploaderFormControlConfig extends BaseFormControlConfig
{
    use Exportable;

    private string $uploadRoute = '';

    private string $removeImageRoute = '';

    private string $loadImagesRoute = '';

    /**
     * @return string
     */
    public function getUploadRoute(): string
    {
        return $this->uploadRoute;
    }

    /**
     * @param  string  $uploadRoute
     * @return self
     */
    public function setUploadRoute(string $uploadRoute): self
    {
        $this->uploadRoute = $uploadRoute;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemoveImageRoute(): string
    {
        return $this->removeImageRoute;
    }

    /**
     * @param  string  $removeImageRoute
     * @return self
     */
    public function setRemoveImageRoute(string $removeImageRoute): self
    {
        $this->removeImageRoute = $removeImageRoute;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoadImagesRoute(): string
    {
        return $this->loadImagesRoute;
    }

    /**
     * @param  string  $loadImagesRoute
     * @return self
     */
    public function setLoadImagesRoute(string $loadImagesRoute): self
    {
        $this->loadImagesRoute = $loadImagesRoute;
        return $this;
    }

    public function getSupportedMimes(): string
    {
        return $this->takeSingleRule('mimes');
    }

    public function getImageMaxFileSize(): string
    {
        return $this->takeSingleRule('max');
    }

    private function takeSingleRule(string $ruleStartsWith): string
    {
        $rule = array_filter($this->getSingleRules(), fn ($x) => str_starts_with($x, "$ruleStartsWith:"));
        if (count($rule) === 0) {
            throw new \Exception('Rule does not exists for the form control!');
        }

        return str_replace($ruleStartsWith . ':', '', reset($rule));
    }
}
