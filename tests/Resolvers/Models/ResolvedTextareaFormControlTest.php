<?php

namespace Zhelyazko777\Forms\Tests\Resolvers\Models;

use Zhelyazko777\Forms\Resolvers\Models\ResolvedTextareaFormControl;
use Zhelyazko777\Forms\Tests\Resolvers\Models\Abstractions\BaseResolvedFormControlTest;

class ResolvedTextareaFormControlTest extends BaseResolvedFormControlTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ResolvedTextareaFormControl;
    }
}