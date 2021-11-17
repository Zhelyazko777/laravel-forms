<?php

namespace Zhelyazko777\Forms\Tests\TestClasses;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PetOwnerPivot extends Pivot
{
    protected $table = 'owner_pet';
}