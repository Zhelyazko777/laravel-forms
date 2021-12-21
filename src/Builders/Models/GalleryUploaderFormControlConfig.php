<?php

namespace Zhelyazko777\Forms\Builders\Models;

use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;

class GalleryUploaderFormControlConfig extends BaseFormControlConfig
{
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
}
