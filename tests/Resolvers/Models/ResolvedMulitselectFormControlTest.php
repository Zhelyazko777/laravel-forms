<?php

namespace Zhelyazko777\Forms\Tests\Resolvers\Models;

use Zhelyazko777\Forms\Resolvers\Models\ResolvedMultiselectFormControl;
use Zhelyazko777\Forms\Tests\Resolvers\Models\Abstractions\BaseResolvedFormControlTest;

class ResolvedMulitselectFormControlTest extends BaseResolvedFormControlTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ResolvedMultiselectFormControl;
    }
}