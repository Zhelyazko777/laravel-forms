<?php

namespace Zhelyazko777\Forms\Tests\Resolvers\Models;

use Zhelyazko777\Forms\Resolvers\Models\ResolvedSelectFormControl;
use Zhelyazko777\Forms\Tests\Resolvers\Models\Abstractions\BaseResolvedFormControlTest;

class ResolvedSelectFormControlTest extends BaseResolvedFormControlTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ResolvedSelectFormControl;
    }
}