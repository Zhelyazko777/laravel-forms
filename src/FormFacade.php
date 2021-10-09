<?php

namespace Zhelyazko777\Forms;

use Illuminate\Support\Facades\Facade;

class FormFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravelForms';
    }
}
