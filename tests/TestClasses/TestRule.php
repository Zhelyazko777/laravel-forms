<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Contracts\Validation\Rule;

class TestRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return true;
    }

    public function message(): string
    {
        return 'Some test msg';
    }
}