<?php

namespace Zhelyazko777\Forms\Tests\Resolvers\Models;

use Zhelyazko777\Forms\Resolvers\Models\ResolvedGalleryUploaderFormControl;
use Zhelyazko777\Forms\Tests\Resolvers\Models\Abstractions\BaseResolvedFormControlTest;

class ResolvedGalleryUploaderFormControlTest extends BaseResolvedFormControlTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ResolvedGalleryUploaderFormControl;
    }
}