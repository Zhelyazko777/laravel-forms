<?php

namespace Zhelyazko777\Forms\Resolvers;

use Illuminate\Database\Eloquent\Model;
use Zhelyazko777\Forms\Builders\Models\Abstractions\BaseFormControlConfig;
use Zhelyazko777\Forms\Resolvers\Contracts\ControlResolverInterface;
use Zhelyazko777\Forms\Resolvers\Models\Abstractions\BaseResolvedFormControl;
use Zhelyazko777\Forms\Resolvers\Models\ResolvedGalleryUploaderFormControl;
use Zhelyazko777\LaravelSimpleMapper\SimpleMapper;

class GalleryUploaderResolver implements ControlResolverInterface
{
    public function resolve(BaseFormControlConfig $control, Model $model): BaseResolvedFormControl
    {
        return SimpleMapper::map($control, new ResolvedGalleryUploaderFormControl);
    }
}