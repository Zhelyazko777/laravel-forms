<?php

namespace Zhelyazko777\Forms\Tests\Resolvers\Models;

use Zhelyazko777\Forms\Resolvers\Models\ResolvedSwitchFormControl;
use Zhelyazko777\Forms\Tests\Resolvers\Models\Abstractions\BaseResolvedFormControlTest;

class ResolvedSwitchFormControlTest extends BaseResolvedFormControlTest
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new ResolvedSwitchFormControl;
    }
}