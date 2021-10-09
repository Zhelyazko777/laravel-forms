<?php

namespace Zhelyazko777\Forms\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    public function passes($attribute, $value): bool
    {
        if ($value) {
            return preg_match('/^(\+)?(359|0)8[0-9]{8}$/', $value) === 1;
        }

        return true;
    }

    public function message(): string
    {
        return 'Въведеният телефон е невалиден';
    }
}
